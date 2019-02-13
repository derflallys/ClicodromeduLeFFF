import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';

import {Observable} from 'rxjs';
import {ListWordService} from './list-word.service';

@Component({
  selector: 'app-list-word',
  templateUrl: './list-word.component.html',
  styleUrls: ['./list-word.component.css']
})
export class ListWordComponent implements OnInit {
  words: Observable<string>[];
  word  ;
  constructor(private route: ActivatedRoute, private listWordService: ListWordService ) { }


  ngOnInit() {
    this.word = this.route.snapshot.paramMap.get('word');
    this.listWordService.getListWords(this.word).subscribe(
      words => {this.words = words; }
    );
  }

}
