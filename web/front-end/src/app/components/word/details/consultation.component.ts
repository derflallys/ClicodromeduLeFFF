import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {WordService} from '../../../services/word.service';
import {Word} from '../../../models/Word';

@Component({
    selector: 'app-consultation',
    templateUrl: './consultation.component.html',
    styleUrls: ['./consultation.component.css']
})
export class ConsultationComponent implements OnInit {
    word: Word;
    searchInput: string;
    tagsSplit: string;

    loading = {
        status: false,
        color: 'accent',
        mode: 'indeterminate',
        value: 50
    };

    constructor(private route: ActivatedRoute, private service: WordService ) {}

    ngOnInit() {
        this.loading.status = true;
        this.service.getWord(this.route.snapshot.paramMap.get('id')).subscribe(
            w => {
                this.word = w;
                this.tagsSplit = w.tags.replace(/;/g, ' / ');
                this.loading.status = false;
            }, error => {
                this.loading.status = false;
                this.word = null;
            }
        );
    }

}
