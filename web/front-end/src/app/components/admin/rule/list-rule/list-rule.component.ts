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
import {Rule} from '../../../../models/Rule';
import {ActivatedRoute} from '@angular/router';
import {CategoryService} from '../../../../services/category.service';
import {RuleService} from '../../../../services/rule.service';
import {Category} from '../../../../models/Category';
import {InfosDialogComponent} from '../../../utils/infos-dialog.component';


@Component({
    selector: 'app-list-rule',
    templateUrl: './list-rule.component.html',
    styleUrls: ['./list-rule.component.css']
})
export class ListRuleComponent implements OnInit {
    allRules: Rule[];
    rules: Rule[];
    categories: Category[];
    categoriesLoaded = false;
    rulesLoaded = false;
    dataSource = new MatTableDataSource();
    displayedColumns: string[] = [
        'category', 'applicationLevel', 'wordTags' , 'categoryTags' , 'result' , 'actions'
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
        private ruleService: RuleService,
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
                if (this.rulesLoaded) {
                    this.loading.status = false;
                }
            }, error => {
                this.loading.status = false;
                this.snackBar.open('❌ Une erreur s\'est produite lors du chargement des catégories !', 'Fermer', this.config);
            }
        );
        this.ruleService.getAllRules().subscribe(
            res => {
                this.rules = res;
                this.allRules = res;
                this.rulesLoaded = true;
                if (this.categoriesLoaded) {
                    this.loading.status = false;
                }
                this.refreshTable();
            },
            error => {
                this.loading.status = false;
                this.snackBar.open('❌ Une erreur s\'est produite lors du chargement des règles !', 'Fermer', this.config);
            }
        );
    }
    refreshTable() {
        this.dataSource = new MatTableDataSource(this.rules);
        this.dataSource.sort = this.sort;
    }
    sortData(sort: Sort) {
        const data = this.rules.slice();
        if (!sort.active || sort.direction === '') {
            this.rules = data;
            return;
        }

        this.rules = data.sort((a, b) => {
            const isAsc = sort.direction === 'asc';
            switch (sort.active) {
                case 'category': return compare(a.category.name, b.category.name, isAsc);
                case 'applicationLevel': return compare(a.applicationLevel, b.applicationLevel, isAsc);
                case 'wordTags': return compare(a.wordTags, b.wordTags, isAsc);
                case 'categoryTags': return compare(a.categoryTags, b.categoryTags, isAsc);
                case 'result': return compare(a.result, b.result, isAsc);
                default: return 0;
            }
        });
        this.refreshTable();
    }
    deleteRule(rule: Rule) {
        const formule =  '{"' + rule.category.name + '"}, {' + rule.applicationLevel + '}, {' +
            rule.wordTags + '}, {' + rule.categoryTags + '} ==> ' + rule.result;
        const dialogConfig = new MatDialogConfig();
        dialogConfig.disableClose = true;
        dialogConfig.autoFocus = true;
        dialogConfig.data = {
            title: 'Suppression de la règle "' + formule + '"',
            content: 'Êtes-vous sûr de vouloir supprimer cette règle ? Cette action est irreversible.'
        };

        const dialogRef = this.dialog.open(InfosDialogComponent, dialogConfig);
        dialogRef.afterClosed().subscribe(result => {
            if (result === true) {
                const config = new MatSnackBarConfig();
                config.verticalPosition = 'bottom';
                config.horizontalPosition = 'center';
                config.duration = 5000;
                this.snackBar.open('⌛ Suppression en cours...', 'Fermer', config);
                this.ruleService.deleteRule(rule.id).subscribe(
                    res => {
                        this.snackBar.open('✅ Suppression effectuée avec succès !', 'Fermer', config);
                        this.allRules.splice(this.allRules.findIndex(item => (item.id === rule.id)), 1);
                        this.refreshTable();
                    }, error => {
                        this.snackBar.open('❌ Une erreur s\'est produite lors de la suppression !', 'Fermer', config);
                    }
                );
            }
        });
    }
    selectCategory(idCategory) {
        this.rules = this.allRules;
        if (idCategory !== 0) {
            this.rules = this.rules.filter(item => item.category.id === idCategory);
        }
        this.refreshTable();
    }
}
function compare(a: number | string, b: number | string, isAsc: boolean) {
    return (a < b ? -1 : 1) * (isAsc ? 1 : -1);
}
