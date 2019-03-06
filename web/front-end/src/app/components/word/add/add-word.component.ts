import { Component, OnInit } from '@angular/core';
import {Word} from '../../../models/Word';
import {ActivatedRoute, Router} from '@angular/router';
import {WordService} from '../../../services/word.service';
import {Tags} from '../../../models/Tags';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Category} from '../../../models/Category';



@Component({
  selector: 'app-add-word',
  templateUrl: './add-word.component.html',
  styleUrls: ['./add-word.component.css']
})
export class AddWordComponent  implements OnInit {
  addWord: FormGroup;
  word: Word  ;
  categories: Category[];
  tags: Tags;
  error = false;
  constructor(private formBuilder: FormBuilder, private router: ActivatedRoute, private service: WordService, private route: Router) { }
  genres = ['Feminin' , 'Masculin'];
  nombres = ['Pluriel' , 'Singulier'];
  wordTags;

  onSubmit() {
    console.log('submit');
    if (this.addWord.invalid) {
      this.error = true;
      return;
    }
    console.log(this.addWord.controls.lemme.value);
    const lemme = this.addWord.controls.lemme.value;
    const cat = this.addWord.controls.category.value;
    console.log(this.categories);
    console.log(cat);
    const category: Category = this.categories.filter(obj => {
      return obj.id === Number(cat); })[0];
    console.log(category);
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
    this.word = new  Word(null, lemme, genre, nombre, category);
    this.tags = new Tags(this.addWord.controls.obja.value, this.addWord.controls.objde.value,
      this.addWord.controls.obj.value, this.addWord.controls.obl.value);
    this.wordTags = {
      word: this.word,
      tags: this.tags
    };
    // if (Object.keys(this.wordTags.tags).length === 0 ) {
    this.service.addWordModified(this.wordTags).subscribe(response => {console.log(response) ; if (response.status === 200) {
      this.route.navigate(['/list', this.word.value]);
    } else {
      this.error = true;
    }});
   /* } else {
      this.service.addWordModified(this.word);
    }*/

    console.log(JSON.stringify(this.wordTags));
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
    this.service.getCategories().subscribe(
      categories => {
        this.categories = categories;
      },
    );
  }

}
