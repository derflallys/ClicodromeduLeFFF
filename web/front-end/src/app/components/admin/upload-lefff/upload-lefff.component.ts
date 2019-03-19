import { Component, OnInit } from '@angular/core';
import {ImportExportService} from '../../../services/import-export.service';
import {FormBuilder, Validators} from '@angular/forms';

@Component({
  selector: 'app-upload-lefff',
  templateUrl: './upload-lefff.component.html',
  styleUrls: ['./upload-lefff.component.css']
})

export class UploadLefffComponent implements OnInit {
  formGroup = this.fb.group({
    file: [null, Validators.required]
  });
  lefffFile: File = null;
  lefff: any[] = new Array();
  handleFileInput($event) {
    if ($event.target.files && $event.target.files.length) {
      this.lefffFile = $event.target.files.item(0);
      this.parsemlefff();
    }

  }
  parsemlefff() {
    const reader = new FileReader();
    reader.onload = (e) => {
      // console.log(reader.result);
      let row ;
      let i = 0 ;
      const dataPerLine = reader.result.toString().split('\n');
      const taille = dataPerLine.length;
      console.log(taille);
      while (i < taille) {
        if (dataPerLine[i] !== '') {
          row  = dataPerLine[i].split('\t');
          if (i > 0) {
            const sub = new Array();
            for (let j = 0; j < row.length; ++j) {
              if (row[j] !== '') {
                sub.push(row[j]);
              }
            }
            if (sub.length !== 0 && sub[0] === sub[2]) {
              this.lefff.push(sub);
            }
          }
        } else {
          dataPerLine.splice(i, 1);
        }
        i++;
      }
      console.log(this.lefff);
    };
    reader.readAsText(this.lefffFile);
  }
  uploadFileToActivity() {
    this.importExportService.sendFileToImport(this.lefff).subscribe(data => {
      // do something, if upload success
    }, error => {
      console.log(error);
    });
  }
  constructor(private importExportService: ImportExportService, private fb: FormBuilder) { }

  ngOnInit() {
  }

}
