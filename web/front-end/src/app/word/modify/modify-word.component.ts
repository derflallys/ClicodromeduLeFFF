import { Component, OnInit } from '@angular/core';
import {Word} from '../Word';
import { Injectable } from '@angular/core';
import {Observable, throwError} from 'rxjs';
import {ActivatedRoute} from '@angular/router';
import {WordService} from "../word.service";




@Component({
  selector: 'app-modify-word',
  templateUrl: './modify-word.component.html',
  styleUrls: ['./modify-word.component.css']
})
export class ModifyWordComponent  implements OnInit {
  word  ;
  words: Observable<string>[];
  constructor(private route: ActivatedRoute, private service: WordService ) { }
  categorie = ['Verbe', 'Nom', 'Adverbe', 'Adjectif'];
  genre = ['Feminin', 'Masculin'];
  nombre = ['Pluriel', 'Singulier'];
  submitted = false;

  onSubmit() { this.submitted = true; }
  ngOnInit() {

  }

}
