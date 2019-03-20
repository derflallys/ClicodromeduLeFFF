import { Component, OnInit } from '@angular/core';
import {ImportExportService} from '../../services/import-export.service';
import {MatSnackBar, MatSnackBarConfig} from '@angular/material';

@Component({
  selector: 'app-import-export',
  templateUrl: './import-export.component.html',
  styleUrls: ['./import-export.component.css'],
})
export class ImportExportComponent implements OnInit {
  requestImport = false;
  requestExport = false;
  errorExport = false;

  constructor(private importExportService: ImportExportService, public snackBar: MatSnackBar) {}

  ngOnInit() {
  }

  doExport() {
    this.requestExport = true;
    const config = new MatSnackBarConfig();
    config.verticalPosition = 'bottom';
    config.horizontalPosition = 'center';
    config.duration = 5000;
    this.importExportService.doExport().subscribe(
        res => {
          this.requestExport = false;
          this.snackBar.open('✅ Export effectué avec succès.', 'Fermer', config);
        }, error => {
          this.requestExport = false;
          this.errorExport = true;
          this.snackBar.open('❌ L\'export à échoué.', 'Fermer', config);
        }
    );
    console.log('export');
  }
}
