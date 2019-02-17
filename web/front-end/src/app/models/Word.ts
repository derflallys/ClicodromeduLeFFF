import {IWord} from './IWord';
import {Category} from './Category';

export class Word implements IWord {
      id: number;
      value: string;
      genre: number;
      nombre: number;
      category: Category;


  constructor(id: number = null, value: string, genre: number, nombre: number, category: Category) {
    this.id = null;
    this.value = value;
    this.genre = genre;
    this.nombre = nombre;
    this.category = category;
  }

}
