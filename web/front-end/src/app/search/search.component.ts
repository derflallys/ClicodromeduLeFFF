import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';

@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit {
  wordText = 'manger' ;

  onSubmit() {
    console.log(this.wordText);
    this.router.navigate(['/list-word', this.wordText]);
  }
  constructor(private router: Router ) { }

  ngOnInit() {
  }

}
