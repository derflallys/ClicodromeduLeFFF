import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {WordService} from '../word.service';
import {IWord} from '../IWord';
import {forEach} from "@angular/router/src/utils/collection";



@Component({
  selector: 'app-list-word',
  templateUrl: './list-word.component.html',
  styleUrls: ['./list-word.component.css']
})
export class ListWordComponent implements OnInit {
  words: IWord[] = [] ;
  constructor(private route: ActivatedRoute, private service: WordService ) { }


  ngOnInit(): void {
    this.service.getListWords(this.route.snapshot.paramMap.get('word')).subscribe(
      w => {this.words = w; },
      tap(w => console.log('All: ' + JSON.stringify(w))),

    );
    console.log(this.words);
  }

}
