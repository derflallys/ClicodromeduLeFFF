import { Component, OnInit } from '@angular/core';
import {Word} from '../../../models/Word';
import {ActivatedRoute, Router} from '@angular/router';
import {WordService} from '../../../services/word.service';
import {Tag} from '../../../models/Tag';
import {FormArray, FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Category} from '../../../models/Category';
import {validate} from "codelyzer/walkerFactory/walkerFn";

@Component({
  selector: 'app-add-word',
  templateUrl: './add-word.component.html',
  styleUrls: ['./add-word.component.css']
})
export class AddWordComponent  implements OnInit {
  addWord: FormGroup;
  word: Word  ;
  categories: Category[];
  error = false;

  searchInput: string;
  loading = {
    status: false,
    color: 'primary',
    mode: 'indeterminate',
    value: 50
  };
  tags: [];

  constructor(private formBuilder: FormBuilder, private router: ActivatedRoute, private service: WordService, private route: Router) { }
  wordTags;
  tagstoString(tags): string {
    let textTags = '';
    for (let i = 0; i < tags.length-1 ; i++) {
      textTags = textTags.concat(tags[i].value, ';');
    }
    textTags = textTags.concat(tags[tags.length - 1].value);

    return textTags;
  }

  onSubmit() {
    console.log(this.addWord.value.tags);
    if (this.addWord.invalid) {
      this.error = true;
      return;
    }
    const tags = this.tagstoString(this.addWord.value.tags);
    console.log(tags);
    const lemme = this.addWord.controls.lemme.value;
    const cat = this.addWord.controls.category.value;
    const category: Category = this.categories.filter(obj => {
      return obj.id === Number(cat); })[0];

    this.word = new  Word(null, lemme, category, tags);
    this.service.addWordModified(this.wordTags).subscribe(response => {console.log(response) ; if (response.status === 200) {
      this.route.navigate(['/list', this.word.value]);
    } else {
      this.error = true;
    }});


    console.log(JSON.stringify(this.word));
  }
  createTag() {
    return this.formBuilder.group({
        value: ['']
    });
  }
  addTagField() {
    (this.addWord.controls['tags'] as FormArray).push(this.createTag());
  }

  ngOnInit() {
    this.addWord = this.formBuilder.group({
      lemme: ['', Validators.required],
      category: ['', Validators.required],
      tags : this.formBuilder.array([this.createTag()])
    });
    this.loading.status = true;
    this.service.getCategories().subscribe(
        categories => {
          this.categories = categories;
          this.loading.status = false;
        },
    );
  }


}
