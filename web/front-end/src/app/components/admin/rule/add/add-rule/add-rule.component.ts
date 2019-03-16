import { Component, OnInit } from '@angular/core';
import {Regle} from '../../../../../models/Regle';
import {ActivatedRoute, Router} from '@angular/router';
import {RegleService} from '../../../../../services/regle.service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';

@Component({
  selector: 'app-add-rule',
  templateUrl: './add-rule.component.html',
  styleUrls: ['./add-rule.component.css']
})
export class AddRuleComponent implements OnInit {

    addrule: FormGroup;
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
    constructor(private formBuilder: FormBuilder, private router: ActivatedRoute, private service: RegleService, private route: Router) { }

   onSubmit() {
        console.log('submit');
        if (this.addrule.invalid) {
            this.error = true;
            return;
        }
        console.log(this.addrule.controls.regle.value);
        const regle = this.addrule.controls.regle.value;
        const category = this.addrule.controls.category.value;
        console.log(category);
        const niveau = this.addrule.controls.niveau.value;
        console.log(niveau);
        const radical = this.addrule.controls.radical.value;
        console.log(radical);

        this.regle = new  Regle(null, regle, category, niveau, radical);
    }

    ngOnInit() {
        this.addrule = this.formBuilder.group({
            regle: ['', Validators.required],
            category: ['', Validators.required],
            niveau: ['', Validators.required],
            radical: ['', Validators.required],
        });
        this.loading.status = true;
    }
}
