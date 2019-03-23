import {Component, Input, OnInit} from '@angular/core';

import {ActivatedRoute, Router} from '@angular/router';

import {FormArray, FormBuilder, FormGroup, Validators} from '@angular/forms';
import {RuleService} from '../../../../services/rule.service';
import {Rule} from '../../../../models/Rule';
import {CategoryService} from '../../../../services/category.service';
import {Category} from '../../../../models/Category';
import {MatDialog, MatSnackBar, MatSnackBarConfig} from '@angular/material';

@Component({
    selector: 'app-add-rule',
    templateUrl: './add-rule.component.html',
    styleUrls: ['./add-rule.component.css']
})
export class AddRuleComponent implements OnInit {

    addRule: FormGroup;
    categories: Category[];
    error = false;
    saveRequest = false;
    errorRequest = false;

    @Input() ruleId = null;
    update = false;
    rule: Rule;
    categorySelected = null;
    title = 'Ajout d\'une nouvelle règle';

    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };
    constructor(private formBuilder: FormBuilder,
                private router: ActivatedRoute,
                private ruleService: RuleService,
                private route: Router,
                private categoryService: CategoryService,
                public dialog: MatDialog,
                public snackBar: MatSnackBar) { }

    ngOnInit() {
        this.addRule = this.formBuilder.group({
            category: ['', Validators.required],
            prefix: [''],
            suffix: [''],
            wordTags : this.formBuilder.array([this.createTag(0)]),
            applicationLevel: ['', Validators.required],
            combinationTags : this.formBuilder.array([this.createTag(1)]),

        });
        this.loading.status = true;
        this.categoryService.getCategories().subscribe(
            cat => {
                this.categories = cat;
                if (this.categories.length === 0) {
                    this.errorRequest = true;
                    this.loading.status = false;
                } else {
                    if (this.ruleId != null) {
                        this.loadData();
                    } else {
                        this.categorySelected = this.categories[0].id;
                        this.loading.status = false;
                    }
                }
            }, error => {
                this.loading.status = false;
                this.errorRequest = true;
            }
        );
    }
    loadData() {
        this.ruleService.getRule(this.ruleId).subscribe(
            r => {
                this.rule = new Rule(r.id, r.wordTags, r.categoryTags, r.category, r.applicationLevel, r.result);
                this.title = 'Modification de la règle : ' + this.rule.getFormule();
                const result = r.result.split('{word}');
                this.addRule = this.formBuilder.group({
                    applicationLevel: [r.applicationLevel, Validators.required],
                    category: [r.category.id, Validators.required],
                    prefix: [result[0]],
                    suffix: [result[1]],
                    wordTags: this.formBuilder.array(this.setTagsArray(r.wordTags, 0)),
                    combinationTags : this.formBuilder.array(this.setTagsArray(r.categoryTags, 1))
                });
                this.categorySelected = this.rule.category.id;
                this.loading.status = false;
                this.update = true;
            }, error => {
                this.loading.status = false;
                this.errorRequest = true;
            }
        );
    }
    onSubmit() {
        if (this.addRule.invalid) {
            this.error = true;
            return;
        }
        const rules = this.rulesToString(this.addRule.value.combinationTags);
        const tagMot = this.addRule.controls.wordTags.value;
        const prefixe = this.addRule.controls.prefix.value;
        const suffixe = this.addRule.controls.suffix.value;
        const cat = this.addRule.controls.category.value;
        const niveau = this.addRule.controls.applicationLevel.value;
        let result = '';
        result = result.concat(prefixe, '{word}');
        result = result.concat(suffixe);
        console.log(result);
        const category: Category = this.categories[this.categories.findIndex(
            obj => {
            return obj.id == cat;
        }
        )];
        this.saveRequest = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;
        if (this.update) {
            const rule = new  Rule(this.rule.id, tagMot, rules, category, niveau, result);
            this.snackBar.open('⌛ Modification en cours...', 'Fermer', config);
            this.ruleService.updateRule(rule, this.rule.id).subscribe(
                res => {
                    this.saveRequest = false;
                    this.snackBar.open('✅ Modification effectuée avec succès !', 'Fermer', config);
                    this.route.navigate(['/list/rules']);
                },
                error => {
                    if (error.status === 400) {
                        this.snackBar.open('❌ ' + error.error, 'Fermer', config);
                    }
                    this.error = true;
                    this.saveRequest = false;
                }
            );
        } else {
            const rule = new  Rule(null, tagMot, rules, category, niveau, result);
            this.snackBar.open('⌛ Ajout en cours...', 'Fermer', config);
            this.ruleService.addRegle(rule).subscribe(
                res => {
                    this.saveRequest = false;
                    this.snackBar.open('✅ Ajout effectué avec succès !', 'Fermer', config);
                    this.route.navigate(['/list/rules']);
                },
                error => {
                    if (error.status === 400) {
                        this.snackBar.open('❌ ' + error.error, 'Fermer', config);
                    }
                    this.error = true;
                    this.saveRequest = false;
                }
            );
        }
    }
    setTagsArray(tags, index) {
        const formGroup = [];
        const tab = tags.split(';');
        tab.forEach((tag) => {
            if (index === 0) {
                formGroup.push(this.formBuilder.group(
                    {
                        valueTag: [tag]
                    }
                ));
            } else {
                formGroup.push(this.formBuilder.group(
                    {
                        valueCombination: [tag]
                    }
                ));
            }
        });
        return formGroup;
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
    createTag(index) {
        if (index === 0) {
            return this.formBuilder.group({
                valueTag: ['']
            });
        } else {
            return this.formBuilder.group({
                valueCombination: ['']
            });
        }
    }
    addCombinationTag() {
        (this.addRule.controls.combinationTags as FormArray).push(this.createTag(1));
    }
    addWordTag() {
        (this.addRule.controls.wordTags as FormArray).push(this.createTag(0));
    }
}
