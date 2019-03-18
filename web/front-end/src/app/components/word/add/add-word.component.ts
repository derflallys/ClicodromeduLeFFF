import {Component, Input, OnInit} from '@angular/core';
import {Word} from '../../../models/Word';
import {ActivatedRoute, Router} from '@angular/router';
import {WordService} from '../../../services/word.service';
import {FormArray, FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Category} from '../../../models/Category';
import {MatSnackBar, MatSnackBarConfig} from '@angular/material';

@Component({
    selector: 'app-add-word',
    templateUrl: './add-word.component.html',
    styleUrls: ['./add-word.component.css'],
})
export class AddWordComponent  implements OnInit {
    addWord: FormGroup;
    word: Word;
    categories: Category[];
    errorRequest = false;
    error = false;
    searchInput: string;
    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };
    tags: [];
    selectedCategory;
    saveRequest = false;
    /* variable for modification */
    title = 'Ajout d\'un nouveau mot';
    @Input() wordId = null;
    modification = false;
    constructor(
        private formBuilder: FormBuilder,
        private router: ActivatedRoute,
        private service: WordService,
        private route: Router,
        public snackBar: MatSnackBar
    ) {}
    ngOnInit() {
        this.addWord = this.formBuilder.group({
            lemme: ['', Validators.required],
            category: ['', Validators.required],
            tags : this.formBuilder.array([this.createTag()])
        });
        this.loading.status = true;
        this.service.getCategories().subscribe(
            categories => {
                this.categories = categories;
                if (this.categories.length === 0) {
                    this.errorRequest = true;
                } else {
                    if (this.wordId !== null) {
                        this.loadExistingData();
                    } else {
                        this.selectedCategory = this.categories[0].id;
                        this.loading.status = false;
                    }
                }
            }, error => {
                this.loading.status = false;
                this.errorRequest = true;
            }
        );
    }
    onSubmit() {
        if (this.addWord.invalid) {
            return;
        }
        const tags = this.tagsToString(this.addWord.value.tags);
        console.log(tags);
        const lemme = this.addWord.controls.lemme.value;
        const cat = this.addWord.controls.category.value;
        const category: Category = this.categories.filter(
            obj => {
                return obj.id === Number(cat);
            }
        )[0];
        this.saveRequest = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;

        if (this.modification) {
            const wordModified = new Word(this.word.id, lemme, category, tags, []);
            this.word = wordModified;
            this.service.updateWord(this.word, this.word.id).subscribe(
                response => {
                    console.log(response);
                    this.saveRequest = false;
                    this.snackBar.open('✅ Modification effectuée avec succès !', 'Fermer', config);
                    this.route.navigate(['/show', this.word.id]);
                }, error => {
                    this.error = true;
                    this.saveRequest = false;
                }
            );
        } else {
            this.word = new Word(null, lemme, category, tags, []);
            this.service.addWord(this.word).subscribe(
                response => {
                    console.log(response);
                    this.saveRequest = false;
                    this.snackBar.open('✅ Ajout effectué avec succès !', 'Fermer', config);
                    this.route.navigate(['/list', this.word.value]);
                }, error => {
                    this.error = true;
                    this.saveRequest = false;
                }
            );
            console.log(JSON.stringify(this.word));
        }
    }

    tagsToString(tags): string {
        let textTags = '';
        let empty = true;
        tags.forEach((tag) => {
            if (tag.value !== '') {
                textTags = textTags.concat(tag.value, ';');
                empty = false;
            }
        });
        if (!empty) {
            textTags = textTags.slice(0, textTags.length - 1);
        }
        return textTags;
    }

    createTag() {
        return this.formBuilder.group({
            value: ['']
        });
    }
    addTagField() {
        (this.addWord.controls['tags'] as FormArray).push(this.createTag());
    }
    setTagsArray(tags) {
        const formGroup = [];
        const tab = tags.split(';');
        tab.forEach((tag) => {
            formGroup.push(this.formBuilder.group(
                {
                    value: [tag]
                }
            ));
        });
        return formGroup;
    }

    loadExistingData() {
        this.service.getWordWithoutInflectedForms(this.wordId).subscribe(
            w => {
                this.word = w;
                this.title = 'Modification du mot : ' + w.value;
                this.addWord = this.formBuilder.group({
                    lemme: [w.value, Validators.required],
                    category: [w.category.id, Validators.required],
                    tags : this.formBuilder.array(this.setTagsArray(w.tags))
                });
                this.loading.status = false;
                this.modification = true;
            }, error => {
                this.loading.status = false;
                this.errorRequest = true;
            }
        );
    }
}
