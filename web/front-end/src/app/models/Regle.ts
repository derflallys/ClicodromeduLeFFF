export class Regle {
    id: number;
    value: string;
    category: string;
    niveau: string;
    radical: string;


    constructor(id: number = null, value: string,  category: string, niveau: string, radical: string ) {
        this.id = id;
        this.value = value;
        this.category = category;
        this.niveau = niveau;
        this.radical = radical;
    }

}
