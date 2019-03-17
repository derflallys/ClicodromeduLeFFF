import {Component, Input, OnInit} from '@angular/core';
import {MatSnackBar} from '@angular/material';
import {AddWordComponent} from '../word/add/add-word.component';

@Component({
  selector: 'app-snackbar',
  templateUrl: './snackbar.component.html',
  styleUrls: ['./snackbar.component.css']
})
export class SnackbarComponent implements OnInit {

  constructor(private snackBar: MatSnackBar) {}
  message: string;
  error: boolean;
  openSnackBar(message: string, error: boolean) {
    this.message = message;
    this.snackBar.openFromComponent(AddWordComponent, {
      duration: 500,
    });
  }

  ngOnInit() {
  }

}
