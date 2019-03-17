import { Component, OnInit } from '@angular/core';
import {Word} from '../../../models/Word';
import {ActivatedRoute, Router} from '@angular/router';
import {WordService} from '../../../services/word.service';
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
  // tags: Tags;
  error = false;

  searchInput: string;
  loading = {
    status: false,
    color: 'accent',
    mode: 'indeterminate',
    value: 50
  };
  tagsAdded: string[];

  constructor(private formBuilder: FormBuilder, private router: ActivatedRoute, private service: WordService, private route: Router) { }
/*  genres = ['Feminin' , 'Masculin'];
  nombres = ['Pluriel' , 'Singulier'];*/
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

    this.word = new Word(null, lemme, category, this.tagsAdded.join(';'), []);
    this.wordTags = {
      word: this.word,
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
    });
    this.tagsAdded = [];
    this.tagsAdded.push(null);
    this.loading.status = true;
    this.service.getCategories().subscribe(
        categories => {
          this.categories = categories;
          this.loading.status = false;
        },
    );
  }

  addTag() {
    this.tagsAdded.push(null);
  }
}
