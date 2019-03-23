import {Category} from './Category';

export class Rule {
    id: number;
    wordTags: string;
    categoryTags: string;
    category: Category;
    applicationLevel: number;
    result: string;
    constructor(id: number, tagWord: string, tagCategory: string, category: Category, niveau: number, result: string) {
        this.id = id;
        this.wordTags = tagWord;
        this.categoryTags = tagCategory;
        this.category = category;
        this.applicationLevel = niveau;
        this.result = result;
    }
    getFormule() {
        return '{"' + this.category.name + '"}, {' + this.applicationLevel + '}, {' +
            this.wordTags + '}, {' + this.categoryTags + '} ==> ' + this.result;
    }
}
