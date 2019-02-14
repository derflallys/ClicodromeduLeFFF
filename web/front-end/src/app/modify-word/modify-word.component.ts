import { Component, OnInit } from '@angular/core';
import {Word} from '../Word';
import { Injectable } from '@angular/core';
import {Observable, throwError} from 'rxjs';
import {ActivatedRoute} from '@angular/router';
import {ModifyWordService} from './modify-word.service';



@Injectable({
  providedIn: 'root'
})
@Component({
  selector: 'app-modify-word',
  templateUrl: './modify-word.component.html',
  styleUrls: ['./modify-word.component.css']
})
export class ModifyWordComponent  implements OnInit {
  word  ;
  words: Observable<string>[];
  constructor(private route: ActivatedRoute, private addWordModified: ModifyWordService ) { }
  categorie = ['Verbe', 'Nom', 'Adverbe', 'Adjectif'];
  genre = ['Feminin', 'Masculin'];
  nombre = ['Pluriel', 'Singulier'];
  model = new Word('manger', this.genre[0], this.nombre[0],'' ,'' ,'' ,'' ,'' );
  submitted = false;

  onSubmit() { this.submitted = true; }
  ngOnInit() {
    this.word = this.route.snapshot.paramMap.get('word');
    this.addWordModified.addWordModified(this.word)
        .subscribe(words => this.words.push(this.word));
  }

}
