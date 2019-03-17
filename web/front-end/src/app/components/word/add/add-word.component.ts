import {Component, OnInit} from '@angular/core';
import {Word} from '../../../models/Word';
import {ActivatedRoute, Router} from '@angular/router';
import {WordService} from '../../../services/word.service';
import {Tag} from '../../../models/Tag';
import {FormArray, FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Category} from '../../../models/Category';
import {validate} from 'codelyzer/walkerFactory/walkerFn';
import {MatSnackBar, MatSnackBarConfig} from '@angular/material';

@Component({
    selector: 'app-add-word',
    templateUrl: './add-word.component.html',
    styleUrls: ['./add-word.component.css'],
})
export class AddWordComponent  implements OnInit {
    addWord: FormGroup;
    word: Word  ;
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
    wordTags;
    selectedCategory;
    saveRequest = false;

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
                this.loading.status = false;
                if (this.categories.length === 0) {
                    this.errorRequest = true;
                } else {
                    this.selectedCategory = this.categories[0].id;
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
        this.word = new Word(null, lemme, category, tags, []);
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;

        this.service.addWord(this.wordTags).subscribe(
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

    tagsToString(tags): string {
        let textTags = '';
        for (let i = 0; i < tags.length - 1 ; i++) {
            textTags = textTags.concat(tags[i].value, ';');
        }
        textTags = textTags.concat(tags[tags.length - 1].value);
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
}
