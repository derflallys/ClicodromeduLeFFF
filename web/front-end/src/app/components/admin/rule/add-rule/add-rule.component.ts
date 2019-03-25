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
    newRadicalChecked = false;
    prefixResult = '';
    suffixResult = '';
    newRadical = '';
    msgError = '';
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
            radical: [''],
            wordTags : this.formBuilder.array([this.createTag(0)]),
            applicationLevel: ['', Validators.required],
            combinationTags : this.formBuilder.array([this.createTag(1)]),
            newRadicalChecked: false,
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
                const newRadical = !r.result.includes('{word}');
                let existPrefix = '';
                let existSuffix = '';
                let existRadical = '';
                if (newRadical) {
                    this.newRadicalChecked = true;
                    existRadical = r.result;
                    this.newRadical = existRadical;
                } else {
                    this.newRadicalChecked = false;
                    existPrefix = r.result.split('{word}')[0];
                    existSuffix = r.result.split('{word}')[1];
                    this.prefixResult = existPrefix;
                    this.suffixResult = existSuffix;
                }
                this.addRule = this.formBuilder.group({
                    applicationLevel: [r.applicationLevel, Validators.required],
                    category: [r.category.id, Validators.required],
                    prefix: [existPrefix],
                    suffix: [existSuffix],
                    radical: [existRadical],
                    wordTags: this.formBuilder.array(this.setTagsArray(r.wordTags, 0)),
                    combinationTags : this.formBuilder.array(this.setTagsArray(r.categoryTags, 1)),
                    newRadicalChecked: newRadical,
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
        this.error = false;
        if (this.addRule.invalid) {
            return;
        }
        const rules = this.combinationTagsToString(this.addRule.controls.combinationTags.value);
        const tagMot = this.wordTagsToString(this.addRule.controls.wordTags.value);
        const cat = this.addRule.controls.category.value;
        const niveau = this.addRule.controls.applicationLevel.value;
        const category: Category = this.categories[this.categories.findIndex(
            obj => {
                return obj.id === cat;
            }
        )];
        let result = '';
        if (this.newRadicalChecked) {
            const radical = this.addRule.controls.radical.value;
            if ( radical === undefined || radical.trim() === '' ) {
                this.error = true;
                this.msgError = 'Un nouveau radical doit être rensigné dans le résultat de la règle.';
                return;
            } else {
                result = radical.trim();
            }
        } else {
            const prefixe = this.addRule.controls.prefix.value;
            const suffixe = this.addRule.controls.suffix.value;
            if ( (prefixe === undefined || prefixe.trim() === '' ) && (prefixe === undefined || prefixe.trim() === '' )) {
                this.error = true;
                this.msgError = 'Un préfixe ou un suffixe doit être rensigné dans le résultat de la règle.';
                return;
            } else {
                result = result.concat(prefixe.trim(), '{word}');
                result = result.concat(suffixe.trim());
            }
        }
        console.log(result);
        this.saveRequest = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;
        if (this.update) {
            const rule = new Rule(this.rule.id, tagMot, rules, category, niveau, result);
            this.snackBar.open('⌛ Modification en cours...', 'Fermer', config);
            this.ruleService.updateRule(rule).subscribe(
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
                    this.msgError = 'Une erreur s\'est produite.';
                    this.saveRequest = false;
                }
            );
        } else {
            const rule = new Rule(null, tagMot, rules, category, niveau, result);
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
                    this.msgError = 'Une erreur s\'est produite.';
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
    combinationTagsToString(rules): string {
        let textrules = '';
        let empty = true;
        rules.forEach((tag) => {
            if (tag.valueCombination !== '') {
                textrules = textrules.concat(tag.valueCombination, ';');
                empty = false;
            }
        });
        if (!empty) {
            textrules = textrules.slice(0, textrules.length - 1);
        }
        return textrules;
    }
    wordTagsToString(rules): string {
        let textrules = '';
        let empty = true;
        rules.forEach((tag) => {
            if (tag.valueTag !== '') {
                textrules = textrules.concat(tag.valueTag, ';');
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
