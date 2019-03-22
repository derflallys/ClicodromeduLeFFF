import {Component, Input, OnInit} from '@angular/core';
import {FormArray, FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Combinaison} from '../../../../models/Combinaison';
import {Category} from '../../../../models/Category';
import {ActivatedRoute, Router} from '@angular/router';
import {MatDialog, MatDialogConfig, MatSnackBar, MatSnackBarConfig, MatTableDataSource} from '@angular/material';
import {InfosDialogComponent} from '../../../utils/infos-dialog.component';
import {CombinationService} from '../../../../services/combination.service';
import {CategoryService} from '../../../../services/category.service';

@Component({
    selector: 'app-combinaison',
    templateUrl: './combinaison.component.html',
    styleUrls: ['./combinaison.component.css']
})
export class CombinaisonComponent implements OnInit {
    addCombi: FormGroup;
    categories: Category[];
    combinaisons: Combinaison[];
    combinaison: Combinaison;
    categorySelected: null;
    categoryNameSelected =  '';
    rules = [] ;
    queryTime: string;
    errorRequest = false;
    update = false;
    displayedColumns: string[] = ['rule', 'actions'];
    dataSource = new MatTableDataSource();
    error = false;
    saveRequest = false;
    title = 'Ajout d\'une nouvelle Combinaison de Régle';

  @Input() combinaisonId = null;
    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };
    constructor(
        private formBuilder: FormBuilder,
        private router: ActivatedRoute,
        private combinationService: CombinationService,
        private categoryService: CategoryService,
        private route: Router,
        public dialog: MatDialog,
        public snackBar: MatSnackBar
    ) { }
    ngOnInit() {
        this.addCombi = this.formBuilder.group({
            category: ['', Validators.required],
            rules : this.formBuilder.array([this.createTag()]),
        });
        if (this.combinaisonId != null) {
          this.loadData();
        }
        this.loading.status = true;
        this.categoryService.getCategories().subscribe(
            categories => {
                this.categories = categories;
                this.loading.status = false;
            },
          error => {
              console.log(error);
              this.categories  = [];
          }
        );
    }

  loadData() {
    this.combinationService.getCombinaison(this.combinaisonId).subscribe(
      w => {
        this.combinaison = w;
        this.title = 'Modification de la Combinaison : ';
        this.addCombi = this.formBuilder.group({
          category: [this.combinaison.category.id, Validators.required],
          rules : this.formBuilder.array(this.setTagsArray(this.combinaison.combinaison))
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
    onSelectCategory($id) {
        console.log('onSelect');
        this.rules = [];
        this.categorySelected = $id;
        this.categoryNameSelected = this.categories.filter(obj => {
        return obj.id === Number(this.categorySelected);
      })[0].name;
        this.combinationService.getCombinaisonByCategory(this.categorySelected).subscribe(
            combin => {
                this.combinaisons = combin;
                this.combinaisons.forEach((r) => {
                    this.rules.push(r);
                });
            },
          error => {
            console.log(error);
            this.rules  = [];
          }
        );
        this.refreshTable();
    }
    refreshTable() {
      this.dataSource = new MatTableDataSource(this.rules);
    }
    createTag() {
        return this.formBuilder.group({
            value: ['']
        });
    }
    onSubmit() {
        console.log(this.addCombi.value);
        if (this.addCombi.invalid) {
            this.error = true;
            return;
        }
        const rules = this.rulesToString(this.addCombi.value.rules);
        const cat = this.addCombi.controls.category.value;
        console.log(this.categories);
        const category: Category = this.categories.filter(obj => {
            return obj.id === Number(cat);
        })[0];
        this.saveRequest = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;
        if (this.update) {
          const tagCategory = new  Combinaison(this.combinaisonId, category, rules);
          this.snackBar.open('⌛ Modification en cours...', 'Fermer', config);

          this.combinationService.updateCombinaison(tagCategory,this.combinaisonId).subscribe(
            response => {
              this.categorySelected = cat ;
              this.onSelectCategory(this.categorySelected);
              this.snackBar.open('✅ Modification effectuée avec succès !', 'Fermer', config);
              this.saveRequest = false;
            },
            error => {
              this.error = true;
              this.saveRequest = false;
            }
          );
        } else {
          const tagCategory = new  Combinaison(null, category, rules);
          this.snackBar.open('⌛ Ajout en cours...', 'Fermer', config);

          this.combinationService.addCombinaison(tagCategory).subscribe(
            response => {
              this.onSelectCategory(this.categorySelected);
              this.snackBar.open('✅ Ajout effectué avec succès !', 'Fermer', config);
              this.saveRequest = false;
            },
            error => {
              this.error = true;
              this.saveRequest = false;
            }
          );
          console.log(JSON.stringify(tagCategory));
        }




    }
    addRule() {
        (this.addCombi.controls.rules as FormArray).push(this.createTag());
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

    deleteCombinaison(combinaison: string, idCombinaison: number) {
        const dialogConfig = new MatDialogConfig();
        console.log(idCombinaison);
        dialogConfig.disableClose = true;
        dialogConfig.autoFocus = true;
        dialogConfig.data = {
            title: 'Suppression du combinaison "' + combinaison + '"',
            content: 'Êtes-vous sûr de vouloir supprimer ce mot ? Cette action est irreversible.'
        };

        const dialogRef = this.dialog.open(InfosDialogComponent, dialogConfig);

        dialogRef.afterClosed().subscribe(result => {
            if (result === true) {
                const config = new MatSnackBarConfig();
                config.verticalPosition = 'bottom';
                config.horizontalPosition = 'center';
                config.duration = 5000;
                this.snackBar.open('⌛ Suppression en cours...', 'Fermer', config);
                this.combinationService.deleteCombinaison(idCombinaison).subscribe(
                    res => {
                        this.snackBar.open('✅ Suppression effectuée avec succès !', 'Fermer', config);
                        this.combinaisons.splice(
                            this.combinaisons.findIndex(
                                item => (item.id === idCombinaison && item.combinaison === combinaison)),
                            1);
                        this.rules =  this.combinaisons;
                        this.refreshTable();
                    }, error => {
                        this.snackBar.open('❌ Une erreur s\'est produite lors de la suppression !', 'Fermer', config);
                    }
                );
            }
        });
    }
}