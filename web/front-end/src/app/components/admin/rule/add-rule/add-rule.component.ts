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
    @Input() ruleId = null;
    update = false;
    rule: Rule;
    title = 'Ajout d\'une nouvelle Régle';

    searchInput: string;
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

   onSubmit() {
        if (this.addRule.invalid) {
            this.error = true;
            return;
        }
        const rules = this.rulesToString(this.addRule.value.rules);
        const tagMot = this.addRule.controls.tagMot.value;
        const prefixe = this.addRule.controls.prefixe.value;
        const suffixe = this.addRule.controls.suffixe.value;
        const cat = this.addRule.controls.category.value;
        const niveau = this.addRule.controls.niveau.value;
        let result = '';
        result = result.concat(prefixe, '{word}');
        result = result.concat(suffixe);
        console.log(result);
        const category: Category = this.categories.filter(obj => {
           return obj.id === Number(cat);
         })[0];
        this.saveRequest = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;
        if (this.update) {
          const rule = new  Rule(this.ruleId, tagMot, rules, category, niveau, result);
          this.snackBar.open('⌛ Modification en cours...', 'Fermer', config);
          this.ruleService.updateRule(rule, this.ruleId).subscribe(
            res => {
              this.saveRequest = false;
              this.snackBar.open('✅ Modification effectuée avec succès !', 'Fermer', config);
              this.route.navigate(['/listRules']);
            },
            error => {
              console.log(error);
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
              this.route.navigate(['/listRules']);
            },
            error => {
              console.log(error);
              this.error = true;
              this.saveRequest = false;
            }
          );
          const rule = new  Rule(null, tagMot, rules, category, niveau, result);
          this.snackBar.open('⌛ Ajout en cours...', 'Fermer', config);
          this.ruleService.addRegle(rule).subscribe(
            res => {
              this.saveRequest = false;
              this.snackBar.open('✅ Ajout effectué avec succès !', 'Fermer', config);
              this.error = true;
              this.route.navigate(['/listRules']);
            },
            error => {
              console.log(error);
              this.error = true;
              this.saveRequest = false;
            }
          );
          console.log(JSON.stringify(rule));

        }
   }

    ngOnInit() {
        this.addRule = this.formBuilder.group({
            tagMot: ['', Validators.required],
            niveau: ['', Validators.required],
            prefixe: [''],
            suffixe: [''],
            category: [''],
            rules : this.formBuilder.array([this.createTag()]),

        });
        if (this.ruleId != null) {
          this.loadData();
        }
        this.loading.status = true;
        this.categoryService.getCategories().subscribe(
            cat => {
              this.categories = cat;
              this.loading.status = false;
            }
          );
    }

  loadData() {
    this.ruleService.getRule(this.ruleId).subscribe(
      w => {
        this.rule = w;
        this.title = 'Modification de la régle : ';
        const result = w.result.split('{word}');
        this.addRule = this.formBuilder.group({
          tagMot: [w.tagWord, Validators.required],
          niveau: [w.niveau, Validators.required],
          prefixe: [result[0]],
          suffixe: [result[1]],
          category: [w.category.id],
          rules : this.formBuilder.array(this.setTagsArray(w.tagCategory))
        });
        this.loading.status = false;
        this.update = true;
      }, error => {
        this.loading.status = false;
        this.error = true;
      }
    );
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
  createTag() {
    return this.formBuilder.group({
      value: ['']
    });
  }
  addRules() {
    (this.addRule.controls.rules as FormArray).push(this.createTag());
  }
}
