import { Component, OnInit } from '@angular/core';
import {Word} from '../Word';
import {ActivatedRoute, Router} from '@angular/router';
import {WordService} from '../word.service';
import {Tags} from '../Tags';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';



@Component({
  selector: 'app-add-word',
  templateUrl: './add-word.component.html',
  styleUrls: ['./add-word.component.css']
})
export class AddWordComponent  implements OnInit {
  addWord: FormGroup;
  word: Word  ;
  categories: any[];
  tags: Tags;
  constructor(private formBuilder: FormBuilder, private router: ActivatedRoute, private service: WordService ) { }
  genres = ['Feminin' , 'Masculin'];
  nombres = ['Pluriel' , 'Singulier'];
  wordTags;

  onSubmit() {
    console.log('submit');
    if (this.addWord.invalid) {
      return;
    }
    console.log(this.addWord.controls.lemme.value);
    const lemme = this.addWord.controls.lemme.value;
    const category = this.addWord.controls.category.value;
    let genre;
    if (this.addWord.controls.genre.value === 'Masculin') {
      genre = 1;
    } else {
      genre = 0;
    }
    let nombre;
    if (this.addWord.controls.nombre.value === 'Pluriel') {
     nombre = 1;
    } else {
      nombre = 0;
    }
    this.word = new  Word(lemme, genre, nombre, category);
    this.tags = new Tags(this.addWord.controls.obja.value, this.addWord.controls.objde.value, this.addWord.controls.obj.value, this.addWord.controls.obl.value);
    this.wordTags = {
      word: this.word,
      tags: this.tags
    };
    //if (Object.keys(this.wordTags.tags).length === 0 ) {
      this.service.addWordModified(this.wordTags);
   /* } else {
      this.service.addWordModified(this.word);
    }*/

    console.log(this.wordTags);
  }

  ngOnInit() {
    this.addWord = this.formBuilder.group({
      lemme: ['', Validators.required],
      category: ['', Validators.required],
      genre: ['', Validators.required],
      nombre: ['', Validators.required],
      obl: [''],
      obj: [''],
      obja: [''],
      objde: ['']
    });
    this.service.getcategories().subscribe(
      categories => {
        this.categories = categories;
      },
    );
  }

}
