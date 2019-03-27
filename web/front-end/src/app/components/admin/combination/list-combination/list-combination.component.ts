import {Component, OnInit, ViewChild} from '@angular/core';
import {
    MatDialog,
    MatDialogConfig,
    MatSnackBar,
    MatSnackBarConfig,
    MatSort,
    MatTableDataSource,
    Sort
} from '@angular/material';
import {ActivatedRoute} from '@angular/router';
import {CategoryService} from '../../../../services/category.service';
import {CombinationService} from '../../../../services/combination.service';
import {Category} from '../../../../models/Category';
import {InfosDialogComponent} from '../../../utils/infos-dialog.component';
import {Combination} from '../../../../models/Combination';


@Component({
    selector: 'app-list-combination',
    templateUrl: './list-combination.component.html',
    styleUrls: ['./list-combination.component.css']
})
export class ListCombinationComponent implements OnInit {
    allCombinations: Combination[];
    combinations: Combination[];
    categories: Category[];
    categoriesLoaded = false;
    combinationsLoaded = false;
    dataSource = new MatTableDataSource();
    displayedColumns: string[] = [
        'category', 'combinationTags', 'actions'
    ];
    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };
    config;
    @ViewChild(MatSort) sort: MatSort;
    constructor(
        private router: ActivatedRoute,
        private categoryService: CategoryService,
        private combinationService: CombinationService,
        public dialog: MatDialog,
        public snackBar: MatSnackBar
    ) {
        this.dataSource.sort = this.sort;
        this.config = new MatSnackBarConfig();
        this.config.verticalPosition = 'bottom';
        this.config.horizontalPosition = 'center';
        this.config.duration = 5000;
    }

    ngOnInit() {
        this.loading.status = true;
        this.categoryService.getCategories().subscribe(
            cat => {
                this.categories = cat;
                this.categoriesLoaded = true;
                if (this.combinationsLoaded) {
                    this.loading.status = false;
                }
            }, error => {
                this.loading.status = false;
                this.snackBar.open('❌ Une erreur s\'est produite lors du chargement des catégories !', 'Fermer', this.config);
            }
        );
        this.combinationService.getAllCombinations().subscribe(
            res => {
                this.combinations = res;
                this.allCombinations = res;
                this.combinationsLoaded = true;
                if (this.categoriesLoaded) {
                    this.loading.status = false;
                }
                this.refreshTable();
            },
            error => {
                this.loading.status = false;
                this.snackBar.open('❌ Une erreur s\'est produite lors du chargement des combinaisons !', 'Fermer', this.config);
            }
        );
    }
    refreshTable() {
        this.dataSource = new MatTableDataSource(this.combinations);
        this.dataSource.sort = this.sort;
    }
    sortData(sort: Sort) {
        const data = this.combinations.slice();
        if (!sort.active || sort.direction === '') {
            this.combinations = data;
            return;
        }

        this.combinations = data.sort((a, b) => {
            const isAsc = sort.direction === 'asc';
            switch (sort.active) {
                case 'category': return compare(a.category.name, b.category.name, isAsc);
                case 'combinationTags': return compare(a.tagsAssociation, b.tagsAssociation, isAsc);
                default: return 0;
            }
        });
        this.refreshTable();
    }
    deleteCombination(combin: Combination) {
        const dialogConfig = new MatDialogConfig();
        dialogConfig.disableClose = true;
        dialogConfig.autoFocus = true;
        dialogConfig.data = {
            title: 'Suppression de la combinaison "' + combin.tagsAssociation + '" (' + combin.category.name + ')',
            content: 'Êtes-vous sûr de vouloir supprimer cette combinaison ? Cette action est irreversible.'
        };

        const dialogRef = this.dialog.open(InfosDialogComponent, dialogConfig);
        dialogRef.afterClosed().subscribe(result => {
            if (result === true) {
                this.snackBar.open('⌛ Suppression en cours...', 'Fermer', this.config);
                this.combinationService.deleteCombination(combin.id).subscribe(
                    res => {
                        this.snackBar.open('✅ Suppression effectuée avec succès !', 'Fermer', this.config);
                        this.allCombinations.splice(this.allCombinations.findIndex(item => (item.id === combin.id)), 1);
                        this.refreshTable();
                    }, error => {
                        this.snackBar.open('❌ Une erreur s\'est produite lors de la suppression !', 'Fermer', this.config);
                    }
                );
            }
        });
    }
    selectCategory(idCategory) {
        this.combinations = this.allCombinations;
        if (idCategory !== 0) {
            this.combinations = this.combinations.filter(item => item.category.id === idCategory);
        }
        this.refreshTable();
    }
}
function compare(a: number | string, b: number | string, isAsc: boolean) {
    return (a < b ? -1 : 1) * (isAsc ? 1 : -1);
}
