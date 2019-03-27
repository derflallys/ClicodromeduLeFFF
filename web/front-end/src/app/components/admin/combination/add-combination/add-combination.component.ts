import {Component, Input, OnInit} from '@angular/core';
import {FormArray, FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Combination} from '../../../../models/Combination';
import {Category} from '../../../../models/Category';
import {ActivatedRoute, Router} from '@angular/router';
import {MatDialog, MatDialogConfig, MatSnackBar, MatSnackBarConfig, MatTableDataSource} from '@angular/material';
import {InfosDialogComponent} from '../../../utils/infos-dialog.component';
import {CombinationService} from '../../../../services/combination.service';
import {CategoryService} from '../../../../services/category.service';
@Component({
    selector: 'app-add-combination',
    templateUrl: './add-combination.component.html',
    styleUrls: ['./add-combination.component.css']
})
export class AddCombinationComponent implements OnInit {
    addCombi: FormGroup;
    categories: Category[];
    combination: Combination;
    title = 'Ajout d\'une nouvelle combinaison de tags';
    error = false;
    saveRequest = false;
    errorRequest = false;
    msgError = '';
    update = false;
    @Input() combinationId = null;
    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };
    /**/

    /*combinaisons: Combination[];
    categorySelected: null;
    categoryNameSelected =  '';
    rules = [] ;
    displayedColumns: string[] = ['rule', 'actions'];
    dataSource = new MatTableDataSource();*/
    constructor(
        private formBuilder: FormBuilder,
        private router: ActivatedRoute,
        private combinationService: CombinationService,
        private categoryService: CategoryService,
        private route: Router,
        public dialog: MatDialog,
        public snackBar: MatSnackBar
    ) {
    }

    ngOnInit() {
        this.addCombi = this.formBuilder.group({
            category: ['', Validators.required],
            tagsAssociation: this.formBuilder.array([this.createTag()]),
        });
        this.loading.status = true;
        this.categoryService.getCategories().subscribe(
            categories => {
                this.categories = categories;
                if (this.combinationId != null) {
                    this.loadData();
                } else {
                    this.loading.status = false;
                }
            },
            error => {
                this.loading.status = false;
                this.errorRequest = true;
            }
        );
    }

    loadData() {
        this.combinationService.getCombination(this.combinationId).subscribe(
            w => {
                this.combination = w;
                this.title = 'Modification de la combinaison : ' + this.combination.tagsAssociation;
                this.addCombi = this.formBuilder.group({
                    category: [this.combination.category.id, Validators.required],
                    tagsAssociation: this.formBuilder.array(this.setTagsArray(this.combination.tagsAssociation))
                });
                this.loading.status = false;
                this.update = true;
            }, error => {
                this.loading.status = false;
                this.errorRequest = true;
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

    createTag() {
        return this.formBuilder.group({
            value: ['']
        });
    }

    addTag() {
        (this.addCombi.controls.tagsAssociation as FormArray).push(this.createTag());
    }

    tagsToString(rules): string {
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

    onSubmit() {
        this.error = false;
        if (this.addCombi.invalid) {
            return;
        }
        const tags = this.tagsToString(this.addCombi.value.tagsAssociation);
        if (tags === undefined || tags.trim() === '') {
            this.error = true;
            this.msgError = 'Veuillez renseigner au moins un tag.';
            return;
        }
        const cat = this.addCombi.controls.category.value;
        const category: Category = this.categories[this.categories.findIndex(
            obj => {
                return obj.id === cat;
            }
        )];
        this.saveRequest = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;
        if (this.update) {
            const tagCategory = new Combination(this.combinationId, category, tags);
            this.snackBar.open('⌛ Modification en cours...', 'Fermer', config);

            this.combinationService.updateCombination(tagCategory, this.combinationId).subscribe(
                response => {
                    this.snackBar.open('✅ Modification effectuée avec succès !', 'Fermer', config);
                    this.saveRequest = false;
                    this.route.navigate(['/list/combinations']);
                },
                error => {
                    if (error.status === 400) {
                        this.snackBar.open('❌ ' + error.error, 'Fermer', config);
                    }
                    this.msgError = 'Une erreur s\'est produite.';
                    this.error = true;
                    this.saveRequest = false;
                }
            );
        } else {
            const tagCategory = new Combination(null, category, tags);
            this.snackBar.open('⌛ Ajout en cours...', 'Fermer', config);
            this.combinationService.addCombination(tagCategory).subscribe(
                response => {
                    this.snackBar.open('✅ Ajout effectué avec succès !', 'Fermer', config);
                    this.saveRequest = false;
                    this.route.navigate(['/list/combinations']);
                },
                error => {
                    if (error.status === 400) {
                        this.snackBar.open('❌ ' + error.error, 'Fermer', config);
                    }
                    this.msgError = 'Une erreur s\'est produite.';
                    this.error = true;
                    this.saveRequest = false;
                }
            );
        }
    }
}
