import {Category} from './Category';


export class Combinaison {
    id: number;
    category: Category;
    combinaison: string ;

    constructor(id: number = null, category: Category, combin: string ) {
        this.id = null;
        this.category = category;
        this.combinaison = combin;
    }
}
