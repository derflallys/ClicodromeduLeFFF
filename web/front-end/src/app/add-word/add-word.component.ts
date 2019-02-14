import { Component, OnInit } from '@angular/core';
import {Word} from '../Word';
import {ActivatedRoute, Router} from '@angular/router';
import {Observable} from 'rxjs';
import {AddWordService} from '../add-word/add-word.service';

@Component({
  selector: 'app-add-word',
  templateUrl: './add-word.component.html',
  styleUrls: ['./add-word.component.css']
})
export class AddWordComponent  implements OnInit {
  word  ;
  words: Observable<string>[];
  constructor(private router: ActivatedRoute, private addWord: AddWordService ) { }
  categorie = ['Verbe', 'Nom' , 'Adverbe' , 'Adjectif'];
  genre = ['', 'Feminin' , 'Masculin'];
  nombre = ['', 'Pluriel' , 'Singulier'];
  model = new Word( 'manger', this.genre[0], this.nombre[0] ,'' ,'','' ,'', this.categorie[0]);
  submitted = false;

  onSubmit() {

    this.submitted = true;
  }

  ngOnInit() {
    this.word = this.router.snapshot.paramMap.get('word');
    this.addWord.addWord(this.word)
        .subscribe(words => this.words.push(this.word));
  }

}
