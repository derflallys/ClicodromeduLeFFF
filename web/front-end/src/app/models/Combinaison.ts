import {Category} from './Category';


export class Combinaison {
    id: number;
    category: Category;
    combinaison: { rule: string }[];

    constructor(id: number = null, category: Category, combin: { rule: string }[]) {
        this.id = null;
        this.category = category;
        this.combinaison = combin;
    }
}
