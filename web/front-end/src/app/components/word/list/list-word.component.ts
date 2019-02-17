import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';

import {WordService} from '../../../services/word.service';
import {IWord} from '../../../models/IWord';
import {Word} from '../../../models/Word';


@Component({
  selector: 'app-list-word',
  templateUrl: './list-word.component.html',
  styleUrls: ['./list-word.component.css']
})
export class ListWordComponent implements OnInit {
  words: Word[] = [];

  constructor(private route: ActivatedRoute, private service: WordService ) { }


  ngOnInit(): void {
    this.service.getListWords(this.route.snapshot.paramMap.get('word')).subscribe(
      w => {this.words = w; },
    );
  }

}
