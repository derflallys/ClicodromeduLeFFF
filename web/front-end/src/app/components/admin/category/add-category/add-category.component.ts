import {Component, Input, OnInit} from '@angular/core';
import {Category} from '../../../../models/Category';
import {ActivatedRoute, Router} from '@angular/router';
import {CategoryService} from '../../../../services/category.service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {MatSnackBar, MatSnackBarConfig} from '@angular/material';

@Component({
  selector: 'app-add-category',
  templateUrl: './add-category.component.html',
  styleUrls: ['./add-category.component.css']
})
export class AddCategoryComponent implements OnInit {
  addCategory: FormGroup;
  category: Category;
  error = false;
  title = 'Ajout d\'une nouvelle categorie';
  errorRequest = false;
  @Input() categoryId = null;
  update  = false;
  loading = {
    status: false,
    color: 'primary',
    mode: 'indeterminate',
    value: 50
  };
  saveRequest = false;
  constructor(
    private formBuilder: FormBuilder,
    private service: CategoryService,
    private route: Router,
    public snackBar: MatSnackBar
  ) { }

  onSubmit() {
    console.log('submit');
    if (this.addCategory.invalid) {
      this.error = true;
      return;
    }
    const code = this.addCategory.controls.code.value;
    console.log(code);
    const name = this.addCategory.controls.name.value;
    console.log(name);
    this.saveRequest = true;
    const config = new MatSnackBarConfig();
    config.verticalPosition = 'bottom';
    config.horizontalPosition = 'center';
    config.duration = 5000;
    if (this.update) {
      this.category = new Category(this.categoryId, code, name);
      this.snackBar.open('⌛ Modification en cours...', 'Fermer', config);
      this.service.updateCategory(this.category, this.category.id).subscribe(
        response => {
          console.log(response);
          this.saveRequest = false;
          this.snackBar.open('✅ Modification effectuée avec succès !', 'Fermer', config);
          this.route.navigate(['/listCategories']);
        }, error => {
          this.error = true;
          this.saveRequest = false;
        }
      );
    } else {
      this.category = new Category(null, code, name);
      this.snackBar.open('⌛ Ajout en cours...', 'Fermer', config);
      this.service.addCategory(this.category).subscribe(
        response => {
          this.saveRequest = false;
          this.snackBar.open('✅ Ajout effectué avec succès !', 'Fermer', config);
          this.route.navigate(['/listCategories']);
        } , error => {
          this.error = true;
          this.saveRequest = false;
        });
    }
    console.log(JSON.stringify(this.category));
  }

  ngOnInit() {
    this.addCategory = this.formBuilder.group({
      code: ['', Validators.required],
      name: ['', Validators.required],
    });
    if (this.categoryId != null) {
      this.loadData();
    }
  }

  loadData() {
    this.service.getCategory(this.categoryId).subscribe(
      w => {
        this.category = w;
        this.title = 'Modification du mot : ' + w.name;
        this.addCategory = this.formBuilder.group({
          code: [w.code, Validators.required],
          name: [w.name, Validators.required],
        });
        this.loading.status = false;
        this.update = true;
      }, error => {
        this.loading.status = false;
        this.errorRequest = true;
      }
    );
  }

}
