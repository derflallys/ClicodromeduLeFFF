import { Component, OnInit } from '@angular/core';
import {MatDialog, MatDialogConfig, MatSnackBar, MatSnackBarConfig, MatTableDataSource} from '@angular/material';
import {Category} from '../../../../models/Category';
import {ActivatedRoute, Router} from '@angular/router';
import {CategoryService} from '../../../../services/category.service';
import {InfosDialogComponent} from '../../../utils/infos-dialog.component';

@Component({
  selector: 'app-list-category',
  templateUrl: './list-category.component.html',
  styleUrls: ['./list-category.component.css']
})
export class ListCategoryComponent implements OnInit {
  categories: Category[] ;
  queryTime: string;

  displayedColumns: string[] = ['code', 'name', 'actions'];
  loading = {
    status: false,
    color: 'primary',
    mode: 'indeterminate',
    value: 50
  };

  dataSource = new MatTableDataSource();
  constructor(
    private router: ActivatedRoute,
    private service: CategoryService,
    public dialog: MatDialog,
    private route: Router,
    public snackBar: MatSnackBar
  ) {}

  ngOnInit() {
    this.loading.status = true;
    this.service.getCategories().subscribe(
      cat => {
        this.categories = cat;
        this.loading.status = false;
        this.refreshTable();
      },
    );
  }
  refreshTable() {
    this.dataSource = new MatTableDataSource(this.categories);
  }

  deleteCategory(name: string, categoryId: number) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.data = {
      title: 'Suppression du mot "' + name + '"',
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
        this.service.deleteCategory(categoryId).subscribe(
          res => {
            this.snackBar.open('✅ Suppression effectuée avec succès !', 'Fermer', config);
            this.categories.splice(this.categories.findIndex(item => (item.id === categoryId && item.name === name)), 1);
            this.refreshTable();
          }, error => {
            this.snackBar.open('❌ Une erreur s\'est produite lors de la suppression !', 'Fermer', config);
          }
        );
      }
    });
  }
}
