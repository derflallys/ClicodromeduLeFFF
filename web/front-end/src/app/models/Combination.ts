import {Category} from './Category';

export class Combination {
    id: number;
    category: Category;
    tagsAssociation: string;

    constructor(id: number = null, category: Category, combin: string) {
        this.id = id;
        this.category = category;
        this.tagsAssociation = combin;
    }
}
