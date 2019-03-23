import {Component, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {WordService} from '../../../services/word.service';
import {Word} from '../../../models/Word';
import {
    MatDialog,
    MatDialogConfig,
    MatSnackBar,
    MatSnackBarConfig, MatSort,
    MatTableDataSource,
} from '@angular/material';
import {InfosDialogComponent} from '../../utils/infos-dialog.component';


@Component({
    selector: 'app-list-word',
    templateUrl: './list-word.component.html',
    styleUrls: ['./list-word.component.css']
})
export class ListWordComponent implements OnInit {
    words: Word[] = [];
    queryTime: string;
    searchInput: string;

    displayedColumns: string[] = ['word', 'category', 'tags', 'actions'];
    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };

    dataSource = new MatTableDataSource();
    @ViewChild(MatSort) sort: MatSort;

    constructor(
        private router: ActivatedRoute,
        private service: WordService,
        public dialog: MatDialog,
        private route: Router,
        public snackBar: MatSnackBar
    ) {}


    ngOnInit(): void {
        this.searchInput = this.router.snapshot.paramMap.get('word').toString();
        this.searchWords();
    }

    changeInputSearch(input: string) {
        this.searchInput = input;
        this.searchWords();
    }
    refreshTable() {
        this.dataSource = new MatTableDataSource(this.words);
        this.dataSource.sort = this.sort;
    }

    applyFilter(filterValue: string) {
        this.dataSource.filter = filterValue.trim().toLowerCase();
    }

    searchWords(): void {
        const queryStartFrom = new Date().getTime();
        this.loading.status = true;
        this.words.splice(0, this.words.length);
        this.service.getListWords(this.searchInput).subscribe(
            w => {
                if (w !== null) {
                    this.words = w;
                } else {
                    this.words = [];
                }
                this.queryTime = ((new Date().getTime() - queryStartFrom) / 1000).toString();
                this.loading.status = false;
                this.refreshTable();
            }, error => {
                this.words = [];
                this.queryTime = ((new Date().getTime() - queryStartFrom) / 1000).toString();
                this.loading.status = false;
                this.refreshTable();
            }
        );
    }

    deleteWord(wordValue: string, wordId: number) {
        const dialogConfig = new MatDialogConfig();

        dialogConfig.disableClose = true;
        dialogConfig.autoFocus = true;
        dialogConfig.data = {
            title: 'Suppression du mot "' + wordValue + '"',
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
                this.service.deleteWord(wordId).subscribe(
                    res => {
                        this.snackBar.open('✅ Suppression effectuée avec succès !', 'Fermer', config);
                        this.words.splice(this.words.findIndex(item => (item.id === wordId && item.value === wordValue)), 1);
                        this.refreshTable();
                    }, error => {
                        this.snackBar.open('❌ Une erreur s\'est produite lors de la suppression !', 'Fermer', config);
                    }
                );
            }
        });
    }
}
function compare(a: number | string, b: number | string, isAsc: boolean) {
    return (a < b ? -1 : 1) * (isAsc ? 1 : -1);
}
