import {IWord} from "./IWord";

export class Word implements IWord {
     lemme: string;
     genre: number;
     nombre: number;
     category: string;

  constructor(lemme: string, genre: number, nombre: number, category: string) {
    this.lemme = lemme;
    this.genre = genre;
    this.nombre = nombre;
    this.category = category;
  }
}
