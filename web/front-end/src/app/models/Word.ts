import {IWord} from "./IWord";

export class Word implements IWord {
     lemme: string;
     genre: number;
     nombre: number;
     category: number;

  constructor(lemme: string, genre: number, nombre: number, category: number) {
    this.lemme = lemme;
    this.genre = genre;
    this.nombre = nombre;
    this.category = category;
  }
}
