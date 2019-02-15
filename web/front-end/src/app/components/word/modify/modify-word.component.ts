import { Component, OnInit } from '@angular/core';
import {Word} from '../../../models/Word';
import { Injectable } from '@angular/core';
import {Observable, throwError} from 'rxjs';
import {ActivatedRoute} from '@angular/router';
import {WordService} from '../../../services/word.service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Tags} from '../../../models/Tags';




@Component({
  selector: 'app-modify-word',
  templateUrl: './modify-word.component.html',
  styleUrls: ['./modify-word.component.css']
})
export class ModifyWordComponent  implements OnInit {
  word: Word ;
  updateWord: FormGroup;
  categories: any[];
  words: Observable<string>[];
  constructor(private formBuilder: FormBuilder, private route: ActivatedRoute, private service: WordService ) { }
  genre = ['Feminin', 'Masculin'];
  nombre = ['Pluriel', 'Singulier'];

  onSubmit() {
    if (this.updateWord.invalid) {
      return;
    }
    const lemme = this.updateWord.controls.lemme.value;
    const category = this.updateWord.controls.category.value;
    let genre;
    if (this.updateWord.controls.genre.value === 'Masculin') {
      genre = 1;
    } else {
      genre = 0;
    }
    let nombre;
    if (this.updateWord.controls.nombre.value === 'Pluriel') {
      nombre = 1;
    } else {
      nombre = 0;
    }
    this.word = new  Word(lemme, genre, nombre, category);
    this.service.updateWord(this.word);

  }
  ngOnInit() {
    this.categories = ['TestCato', 'TestC'];
    this.service.getWord(this.route.snapshot.paramMap.get('id')).subscribe(
      word => {
      this.word = word;
    });
    this.updateWord = this.formBuilder.group({
      lemme: [this.word.lemme, Validators.required],
      category: [this.word.category, Validators.required],
      genre: [this.word.genre, Validators.required],
      nombre: [this.word.nombre, Validators.required],
    });
    this.service.getcategories().subscribe(
      categories => {
        this.categories = categories;
      }
    );
  }

}
