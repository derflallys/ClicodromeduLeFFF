import { Component, OnInit } from '@angular/core';
import {FormArray, FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Combinaison} from '../../../models/Combinaison';
import {Category} from '../../../models/Category';
import {ActivatedRoute, Router} from '@angular/router';
import {Word} from '../../../models/Word';
import {WordService} from '../../../services/word.service';
import {MatTableDataSource} from '@angular/material';
import {CategoryService} from '../../../services/category.service';
@Component({
    selector: 'app-combinaison',
    templateUrl: './combinaison.component.html',
    styleUrls: ['./combinaison.component.css']
})
export class CombinaisonComponent implements OnInit {
    addCombi: FormGroup;
    categories: Category[];
    combinaisons: Combinaison[];
    categorySelected: null;
    rules = [] ;
    queryTime: string;
    errorRequest = false;
    displayedColumns: string[] = ['rule', 'actions'];
    dataSource = new MatTableDataSource();
    error = false;
    saveRequest = false;
    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };
    constructor(
        private formBuilder: FormBuilder,
        private router: ActivatedRoute,
        private wordService: WordService,
        private categoryService: CategoryService,
        private route: Router
    ) {}
    ngOnInit() {
        this.addCombi = this.formBuilder.group({
            category: ['', Validators.required],
            rules : this.formBuilder.array([this.createTag()]),
        });
        this.loading.status = true;
        this.categoryService.getCategories().subscribe(
            categories => {
                this.categories = categories;
                this.loading.status = false;
            },
        );
    }
    onSelectCategory($id) {
        console.log('onSelect');
        this.rules = [];
        this.categorySelected = $id;
        this.wordService.getCombinaison(this.categorySelected).subscribe(
            combin => {
                console.log(combin);
                this.combinaisons = combin;
                this.combinaisons.forEach((r) => {
                    console.log(r.combinaison);
                    this.rules.push(r);
                });
            },
        );
        this.dataSource = new MatTableDataSource(this.rules);
        console.log(this.combinaisons);
    }
    createTag() {
        return this.formBuilder.group({
            value: ['']
        });
    }
    onSubmit() {
        console.log(this.addCombi.value);
        if (this.addCombi.invalid) {
            this.error = true;
            return;
        }
        const rules = this.rulesToString(this.addCombi.value.rules);
        const cat = this.addCombi.controls.category.value;
        console.log(this.categories);
        console.log(cat);
        const category: Category = this.categories.filter(obj => {
            return obj.id === Number(cat);
        })[0];
        this.saveRequest = true;
        const tagCategory = new  Combinaison(null, category, rules );
        this.wordService.addCombinaison(tagCategory).subscribe(response => {console.log(response) ; if (response.status === 200) {
            this.route.navigate(['/home']);
        } else {
            this.error = true;
        }});

        console.log(JSON.stringify(tagCategory));

    }
    addRule() {
        (this.addCombi.controls['rules'] as FormArray).push(this.createTag());
    }
    rulesToString(rules): string {
        let textrules = '';
        let empty = true;
        rules.forEach((tag) => {
            if (tag.value !== '') {
                textrules = textrules.concat(tag.value, ';');
                empty = false;
            }
        });
        if (!empty) {
            textrules = textrules.slice(0, textrules.length - 1);
        }
        return textrules;
    }


}
