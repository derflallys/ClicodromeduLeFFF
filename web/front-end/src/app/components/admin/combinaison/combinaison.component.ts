import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Combinaison} from '../../../models/Combinaison';
import {Category} from '../../../models/Category';
import {ActivatedRoute, Router} from '@angular/router';
import {RulesService} from '../../../services/rules.service' ;
import {CategoryService} from '../../../services/category.service';

@Component({
  selector: 'app-combinaison',
  templateUrl: './combinaison.component.html',
  styleUrls: ['./combinaison.component.css']
})
export class CombinaisonComponent implements OnInit {
  addCombinaison: FormGroup;
  combinaison: Combinaison;
  categories: Category[];
  CombinAdded: {rule: string}[];
  error = false;
  CombinRules;
  constructor(
      private formBuilder: FormBuilder,
      private router: ActivatedRoute,
      private ruleService: RulesService,
      private categoryService: CategoryService,
      private route: Router
  ) {}
  loading = {
    status: false,
    color: 'primary',
    mode: 'indeterminate',
    value: 50
  };

  onSubmit() {
    console.log('submit');
    if (this.addCombinaison.invalid) {
      this.error = true;
      return;
    }

    const cat = this.addCombinaison.controls.category.value;
    console.log(this.categories);
    console.log(cat);
    const category: Category = this.categories.filter(obj => {
      return obj.id === Number(cat);
    })[0];
    console.log(category);

    this.combinaison = new  Combinaison(null, category, this.CombinAdded);
    this.CombinRules = {
        combinaison: this.combinaison,
      };

    this.ruleService.addCombinaison(this.CombinRules).subscribe(response => {console.log(response) ; if (response.status === 200) {
          this.route.navigate([this.combinaison.combinaison]);
      } else {
          this.error = true;
      }});

    console.log(JSON.stringify(this.CombinRules));
  }
  ngOnInit() {
      this.addCombinaison = this.formBuilder.group({
          category: ['', Validators.required],
      });
      this.CombinAdded = [];
      this.CombinAdded.push(null);
      this.loading.status = true;
      this.categoryService.getCategories().subscribe(
          categories => {
              this.categories = categories;
              this.loading.status = false;
          },
      );
  }

}
