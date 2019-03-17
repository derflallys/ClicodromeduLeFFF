import {Category} from './Category';

export class Word {
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
