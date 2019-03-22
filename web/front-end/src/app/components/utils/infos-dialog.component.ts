import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA } from '@angular/material';

@Component({
  selector: 'app-infos-dialog',
  templateUrl: './infos-dialog.component.html',
  styleUrls: ['./infos-dialog.component.css']
})
export class InfosDialogComponent  {
  modalTitle: string;
  modalContent: string;
  modalSubContent: string;
  modalSubSubContent: string;

  constructor(@Inject(MAT_DIALOG_DATA) public data: any) {
    this.modalTitle = data.title;
    this.modalContent = data.content;
    this.modalSubContent = data.content2;
    this.modalSubSubContent = data.content3;
  }
}
