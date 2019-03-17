import {IWord} from './IWord';
import {Category} from './Category';
import {Tag} from './Tag';

export class Word implements IWord {
    id: number;
    value: string;
    category: Category;
    tags: string;
    inflectedForms: string[];


    constructor(id: number = null, value: string, category: Category, tags: string, inflectedForms: string[]) {
        this.id = null;
        this.value = value;
        this.category = category;
        this.tags = tags;
        this.inflectedForms = inflectedForms;
    }

}
