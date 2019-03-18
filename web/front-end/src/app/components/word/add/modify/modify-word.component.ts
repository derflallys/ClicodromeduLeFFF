import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';

@Component({
  selector: 'app-modify-word',
  templateUrl: './modify-word.component.html',
  styleUrls: ['./modify-word.component.css']
})
export class ModifyWordComponent  implements OnInit {
  wordId;
  constructor(private route: ActivatedRoute) { }

  ngOnInit() {
    this.wordId = this.route.snapshot.paramMap.get('id');
  }
}
