import {IWord} from './IWord';
import {Category} from './Category';
import {Tag} from "./Tag";

export class Word implements IWord {
      id: number;
      value: string;
      /*genre: number;
      nombre: number;*/
      category: Category;
      tags: Tag[];


  constructor(id: number = null, value: string, /*genre: number, nombre: number,*/ category: Category, tags: Tag[]) {
    this.id = null;
    this.value = value;
/*    this.genre = genre;
    this.nombre = nombre;*/
    this.category = category;
    this.tags = tags;
  }

}
