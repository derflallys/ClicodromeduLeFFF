import { Component, OnInit } from '@angular/core';
import {Word} from '../Word';

@Component({
  selector: 'app-add-word',
  templateUrl: './add-word.component.html',
  styleUrls: ['./add-word.component.css']
})
export class AddWordComponent  {


  genre = ['Feminin', 'Masculin'];
  nombre = ['Pluriel', 'Singulier'];
  model = new Word( 'manger', this.genre[0], this.nombre[0],'','','','','');
  submitted = false;

  onSubmit() { this.submitted = true; }

  // TODO: Remove this when we're done
  get diagnostic() { return JSON.stringify(this.model); }

}
