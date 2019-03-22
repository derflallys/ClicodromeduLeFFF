import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {WordService} from '../../../services/word.service';
import {Word} from '../../../models/Word';
import {MatDialog, MatDialogConfig, MatSnackBar, MatSnackBarConfig} from '@angular/material';
import {InfosDialogComponent} from '../../utils/infos-dialog.component';

@Component({
    selector: 'app-consultation',
    templateUrl: './consultation.component.html',
    styleUrls: ['./consultation.component.css']
})
export class ConsultationComponent implements OnInit {
    word: Word;
    searchInput: string;
    tagsSplit: string;

    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };

    constructor(
        private router: ActivatedRoute,
        private service: WordService,
        public dialog: MatDialog,
        private route: Router,
        public snackBar: MatSnackBar
    ) {}

    ngOnInit() {
        this.loading.status = true;
        this.service.getWord(this.router.snapshot.paramMap.get('id')).subscribe(
            w => {
                this.word = w;
                this.tagsSplit = w.tags.replace(/;/g, ' / ');
                this.loading.status = false;
            }, error => {
                this.loading.status = false;
                this.word = null;
            }
        );
    }
    deleteWord() {
        const dialogConfig = new MatDialogConfig();

        dialogConfig.disableClose = true;
        dialogConfig.autoFocus = true;
        dialogConfig.data = {
            title: 'Suppression du mot "' + this.word.value + '"',
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
                this.service.deleteWord(this.word.id).subscribe(
                    res => {
                        this.snackBar.open('✅ Suppression effectuée avec succès !', 'Fermer', config);
                        this.route.navigate(['/home', ]);
                    }, error => {
                        this.snackBar.open('❌ Une erreur s\'est produite lors de la suppression !', 'Fermer', config);
                    }
                );
            }
        });
    }
}
