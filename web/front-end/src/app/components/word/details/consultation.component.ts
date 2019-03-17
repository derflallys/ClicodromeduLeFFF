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

    loading = {
        status: false,
        color: 'primary',
        mode: 'indeterminate',
        value: 50
    };

    constructor(private route: ActivatedRoute, private service: WordService ) {}

    ngOnInit() {
        this.loading.status = true;
        this.service.getWord(this.route.snapshot.paramMap.get('id')).subscribe(
            w => {
                this.word = w;
                this.loading.status = false;
            }
        );
    }

}
