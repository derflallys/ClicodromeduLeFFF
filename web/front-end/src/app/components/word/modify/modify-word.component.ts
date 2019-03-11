import { Component, OnInit } from '@angular/core';
import {Word} from '../../../models/Word';
import {Observable} from 'rxjs';
import {ActivatedRoute, Route, Router} from '@angular/router';
import {WordService} from '../../../services/word.service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
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
  error = false;
  constructor(private formBuilder: FormBuilder, private route: ActivatedRoute, private service: WordService, private router: Router) { }
  genres = ['Feminin' , 'Masculin'];
  nombres = ['Pluriel' , 'Singulier'];

  onSubmit() {
    if (this.updateWord.invalid) {
      console.log('Submit');
      return;
    }
    const lemme = this.updateWord.controls.value.value;
    const cat = this.updateWord.controls.category.value;
    const category: Category = this.categories.filter(obj => {
      return obj.id === Number(cat); })[0];
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
    this.newword = new  Word(null, lemme, /*genre, nombre,*/ category, []);
    console.log(JSON.stringify(this.newword));
    this.service.updateWord(this.newword, this.word.id).subscribe(
      response => { if (response.status === 200) {
        this.router.navigate(['/list', this.word.value]);
      } else {
        this.error = true;
      }}
    );

  }
  ngOnInit() {
    this.updateWord = this.formBuilder.group({
      value: ['', Validators.required],
      category: ['', Validators.required],
      genre: ['', Validators.required],
      nombre: ['', Validators.required],
    });
    const id = this.route.snapshot.paramMap.get('id');
    this.service.getWord(Number(id)).subscribe(
      w => {
      this.word = w;
    });

    this.service.getCategories().subscribe(
      categories => {
        this.categories = categories;
      }
    );
  }

}
