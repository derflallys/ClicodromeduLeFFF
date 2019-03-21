import { Component, OnInit } from '@angular/core';

import {ActivatedRoute, Router} from '@angular/router';

import {FormArray, FormBuilder, FormGroup, Validators} from '@angular/forms';
import {RuleService} from '../../../../services/rule.service';
import {Regle} from '../../../../models/Regle';

@Component({
  selector: 'app-add-rule',
  templateUrl: './add-rule.component.html',
  styleUrls: ['./add-rule.component.css']
})
export class AddRuleComponent implements OnInit {

    addRule: FormGroup;
    regle: Regle;
    categories: string;
    radical: string;
    error = false;

    searchInput: string;
    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };
    constructor(private formBuilder: FormBuilder, private router: ActivatedRoute, private service: RuleService, private route: Router) { }

   onSubmit() {
        console.log('submit');
        if (this.addRule.invalid) {
            this.error = true;
            return;
        }
        console.log(this.addRule.controls.regle.value);
        const regle = this.addRule.controls.regle.value;
        const category = this.addRule.controls.category.value;
        console.log(category);
        const niveau = this.addRule.controls.niveau.value;
        console.log(niveau);
        const radical = this.addRule.controls.radical.value;
        console.log(radical);

        this.regle = new  Regle(null, regle, category, niveau, radical);
    }

    ngOnInit() {
        this.addRule = this.formBuilder.group({
            tagMot: ['', Validators.required],
            niveau: ['', Validators.required],
            prefixe: [''],
            suffixe: [''],
            rules : this.formBuilder.array([this.createTag()]),

        });
    }

  createTag() {
    return this.formBuilder.group({
      value: ['']
    });
  }
  addRules() {
    (this.addRule.controls['rules'] as FormArray).push(this.createTag());
  }
}
