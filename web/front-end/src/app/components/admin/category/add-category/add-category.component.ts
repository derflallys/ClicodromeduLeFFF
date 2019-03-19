import { Component, OnInit } from '@angular/core';
import {Category} from '../../../../models/Category';
import {ActivatedRoute, Router} from '@angular/router';
import {CategoryService} from '../../../../services/category.service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';

@Component({
  selector: 'app-add-category',
  templateUrl: './add-category.component.html',
  styleUrls: ['./add-category.component.css']
})
export class AddCategoryComponent implements OnInit {
  addcategory: FormGroup;
  category: Category;
  code: string;
  name: string;
  id: number;
  error = false;

  searchInput: string;
  loading = {
    status: false,
    color: 'primary',
    mode: 'indeterminate',
    value: 50
  };
  constructor(private formBuilder: FormBuilder, private router: ActivatedRoute, private service: CategoryService, private route: Router) { }

  onSubmit() {
    console.log('submit');
    if (this.addcategory.invalid) {
      this.error = true;
      return;
    }
    console.log(this.addcategory.controls.regle.value);
    const code = this.addcategory.controls.code.value;
    console.log(code);
    const name = this.addcategory.controls.name.value;
    console.log(name);
    this.category = new Category();
  }

  ngOnInit() {
    this.addcategory = this.formBuilder.group({
      code: ['', Validators.required],
      name: ['', Validators.required],

    });
    this.loading.status = true;
  }

}
