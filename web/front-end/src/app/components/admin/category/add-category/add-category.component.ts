import {Component, Input, OnInit} from '@angular/core';
import {Location} from '@angular/common';
import {Category} from '../../../../models/Category';
import {Router} from '@angular/router';
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
        public snackBar: MatSnackBar,
        private location: Location
    ) { }
    // method appeler quand le formulaire d'ajout/modification est validé
    onSubmit() {
        this.error = false;
        if (this.addCategory.invalid) {
            return;
        }
        // recupere les valeurs saisies du formulaire
        const code = this.addCategory.controls.code.value;
        console.log(code);
        const name = this.addCategory.controls.name.value;
        console.log(name);
        this.saveRequest = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;
        // si  update est à  vrai , la modification est effecté avec l'appel du service updateCatergory
        if (this.update) {
            this.category = new Category(this.categoryId, code, name);
            this.snackBar.open('⌛ Modification en cours...', 'Fermer', config);
            this.service.updateCategory(this.category, this.category.id).subscribe(
                response => {
                    console.log(response);
                    this.saveRequest = false;
                    this.snackBar.open('✅ Modification effectuée avec succès !', 'Fermer', config);
                    this.route.navigate(['/list/categories']);
                }, error => {
                    this.error = true;
                    this.saveRequest = false;
                    if (error.status === 400) {
                        this.snackBar.open('❌ ' + error.error, 'Fermer', config);
                    }
                }
            );
        } else { // sinon le service addCategory est appelé
            this.category = new Category(null, code, name);
            this.snackBar.open('⌛ Ajout en cours...', 'Fermer', config);
            this.service.addCategory(this.category).subscribe(
                response => {
                    this.saveRequest = false;
                    this.snackBar.open('✅ Ajout effectué avec succès !', 'Fermer', config);
                    this.location.back();
                } , error => {
                    this.error = true;
                    this.saveRequest = false;
                    if (error.status === 400) {
                        this.snackBar.open('❌ ' + error.error, 'Fermer', config);
                    }
                });
        }
        console.log(JSON.stringify(this.category));
    }
    // methode appeler une fois lors de l'initialisation du composant
    ngOnInit() {
      // formBuilder permet d'initialier les inputs du formulaire et d'ajouter des controles sur
        this.addCategory = this.formBuilder.group({
            code: ['', Validators.required],
            name: ['', Validators.required],
        });
        // si categoryId n'est pas null c'est à dire que c'est le composant Modification est appelé avec un input sur AddCategorie
        if (this.categoryId != null) {
            this.loadData();
        }
    }
    // on recharge les données de la categorie en appelant getCategory  du service pour charger les inputs de la categorie
    loadData() {
        this.loading.status = true;
        this.service.getCategory(this.categoryId).subscribe(
            cat => {
                this.category = cat;
                this.title = 'Modification de la catégorie : ' + cat.name;
                this.addCategory = this.formBuilder.group({
                    code: [cat.code, Validators.required],
                    name: [cat.name, Validators.required],
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
