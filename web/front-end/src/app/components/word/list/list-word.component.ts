import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';

import {WordService} from '../../../services/word.service';
import {Word} from '../../../models/Word';


@Component({
    selector: 'app-list-word',
    templateUrl: './list-word.component.html',
    styleUrls: ['./list-word.component.css']
})
export class ListWordComponent implements OnInit {
    words: Word[] = [];
    queryTime: string;
    searchInput: string;

    displayedColumns: string[] = ['word', 'category', 'actions'];
    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };

    constructor(private route: ActivatedRoute, private service: WordService ) {}


    ngOnInit(): void {
        this.searchInput = this.route.snapshot.paramMap.get('word').toString();
        this.searchWords();
    }

    changeInputSearch(input: string) {
        this.searchInput = input;
        this.searchWords();
    }

    searchWords(): void {
        let queryStartFrom = new Date().getTime();
        this.loading.status = true;
        this.words.splice(0, this.words.length);
        this.service.getListWords(this.searchInput).subscribe(
            w => {
                if(w !== null) {
                    this.words = w;
                } else {
                    this.words = [];
                }
                this.queryTime = ((new Date().getTime() - queryStartFrom) / 1000).toString();
                this.loading.status = false;
            }
        );
    }
}
