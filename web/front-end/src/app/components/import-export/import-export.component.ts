import { Component, OnInit } from '@angular/core';
import {ImportExportService} from '../../services/import-export.service';
import {MatSnackBar, MatSnackBarConfig} from '@angular/material';
import {saveAs} from 'file-saver';

@Component({
    selector: 'app-import-export',
    templateUrl: './import-export.component.html',
    styleUrls: ['./import-export.component.css'],
})
export class ImportExportComponent implements OnInit {
    requestImport = false;
    requestExport = false;
    errorImport = false;
    errorExport = false;
    panelOpenState = 0;

    fileToUploadCustom: File = null;
    fileToUploadTxt: File = null;
    fileToUploadMlex: File = null;

    constructor(private importExportService: ImportExportService, public snackBar: MatSnackBar) {}

    ngOnInit() {}
    setPanel(step: number) {
        this.panelOpenState = step;
    }
    doImportSyntaxCustom() {
        this.requestImport = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;
        this.importExportService.importSyntaxCustom(this.fileToUploadCustom).subscribe(
            response => {
                this.requestImport = false;
                this.snackBar.open('✅ Import effectué avec succès.', 'Fermer', config);
            }, error => {
                this.requestImport = false;
                this.errorImport = true;
                this.snackBar.open('❌ L\'import à échoué.', 'Fermer', config);
            }
        );
    }
    doImportSyntaxTxt() {
        this.requestImport = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;
        this.importExportService.importSyntaxTxt(this.fileToUploadTxt).subscribe(
            response => {
                this.requestImport = false;
                this.snackBar.open('✅ Import effectué avec succès.', 'Fermer', config);
            }, error => {
                this.requestImport = false;
                this.errorImport = true;
                this.snackBar.open('❌ L\'import à échoué.', 'Fermer', config);
            }
        );
    }
    doImportSyntaxMLex() {
        this.requestImport = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;
        this.importExportService.importSyntaxMlex(this.fileToUploadMlex).subscribe(
            response => {
                this.requestImport = false;
                this.snackBar.open('✅ Import effectué avec succès.', 'Fermer', config);
            }, error => {
                this.requestImport = false;
                this.errorImport = true;
                this.snackBar.open('❌ L\'import à échoué.', 'Fermer', config);
            }
        );
    }
    doExport() {
        this.requestExport = true;
        const config = new MatSnackBarConfig();
        config.verticalPosition = 'bottom';
        config.horizontalPosition = 'center';
        config.duration = 5000;
        let blob = null;
        this.importExportService.doExport().subscribe(
            response => {
                try {
                    const isFileSaverSupported = !!new Blob();
                } catch (e) {
                    console.log(e);
                    this.requestExport = false;
                    this.errorExport = true;
                    this.snackBar.open('❌ L\'export à échoué.', 'Fermer', config);
                }
                blob = new Blob([response], { type: 'text/plain' });
                saveAs(blob, `export-result.txt`);
                this.requestExport = false;
                this.snackBar.open('✅ Export effectué avec succès.', 'Fermer', config);
            }, error => {
                this.requestExport = false;
                this.errorExport = true;
                if (error.status === 404) {
                    this.snackBar.open('❌ Aucun mot n\'est enregistré dans la base de données.', 'Fermer', config);
                } else {
                    this.snackBar.open('❌ L\'export à échoué.', 'Fermer', config);
                }
            });
    }

    handleFileInput(selectedImport: number, files: FileList) {
        switch (selectedImport) {
            case 0:
                this.fileToUploadCustom = files.item(0);
                this.fileToUploadTxt = null;
                this.fileToUploadMlex = null;
                break;
            case 1:
                this.fileToUploadTxt = files.item(0);
                this.fileToUploadCustom = null;
                this.fileToUploadMlex = null;
                break;
            case 2:
                this.fileToUploadMlex = files.item(0);
                this.fileToUploadTxt = null;
                this.fileToUploadCustom = null;
                break;

        }
    }
}
