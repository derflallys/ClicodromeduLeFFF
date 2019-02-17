import { Component, OnInit } from '@angular/core';
import {Word} from '../../../models/Word';
import { Injectable } from '@angular/core';
import {Observable, throwError} from 'rxjs';
import {ActivatedRoute} from '@angular/router';
import {WordService} from '../../../services/word.service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Tags} from '../../../models/Tags';
import {Category} from '../../../models/Category';




@Component({
  selector: 'app-modify-word',
  templateUrl: './modify-word.component.html',
  styleUrls: ['./modify-word.component.css']
})
export class ModifyWordComponent  implements OnInit {
  word: Word ;
  newword: any;
  updateWord: FormGroup;
  categories: Category[];
  words: Observable<string>[];
  constructor(private formBuilder: FormBuilder, private route: ActivatedRoute, private service: WordService ) { }
  genres = ['Feminin' , 'Masculin'];
  nombres = ['Pluriel' , 'Singulier'];

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
    this.newword = new  Word(null, lemme, genre, nombre, category);
    this.service.updateWord(this.newword, this.word.id).subscribe();

  }
  ngOnInit() {
    this.updateWord = this.formBuilder.group({
      lemme: ['', Validators.required],
      category: ['', Validators.required],
      genre: ['', Validators.required],
      nombre: ['', Validators.required],
    });
    this.service.getWord(this.route.snapshot.paramMap.get('id')).subscribe(
      word => {
      this.word = word;
    });

    this.service.getCategories().subscribe(
      categories => {
        this.categories = categories;
      }
    );
  }

}
