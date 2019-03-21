import {Category} from './Category';

export class Rule {
    id: number;
    tagWord: string;
    tagCategory: string;
    category: Category;
    niveau: number;
    result: string;


  constructor(id: number, tagWord: string, tagCategory: string, category: Category, niveau: number, result: string) {
    this.id = id;
    this.tagWord = tagWord;
    this.tagCategory = tagCategory;
    this.category = category;
    this.niveau = niveau;
    this.result = result;
  }
}
