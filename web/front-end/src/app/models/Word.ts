import {IWord} from './IWord';
import {Category} from './Category';
import {InflectedForm} from './InflectedForm';

export class Word implements IWord {
    id: number;
    value: string;
    category: Category;
    tags: string;
    inflectedForms: InflectedForm[];
    constructor(id: number = null, value: string, category: Category, tags: string, inflectedForms: InflectedForm[]) {
        this.id = id;
        this.value = value;
        this.category = category;
        this.tags = tags;
        this.inflectedForms = inflectedForms;
    }
}
