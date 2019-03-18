import {IWord} from './IWord';
import {Category} from './Category';

export class Word implements IWord {
    id: number;
    value: string;
    category: Category;
    tags: string;
    inflectedForms: string[];
    constructor(id: number = null, value: string, category: Category, tags: string, inflectedForms: string[]) {
        this.id = id;
        this.value = value;
        this.category = category;
        this.tags = tags;
        this.inflectedForms = inflectedForms;
    }
}
