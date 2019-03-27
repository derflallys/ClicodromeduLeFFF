import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';

@Component({
  selector: 'app-modify-combination',
  templateUrl: './modify-combination.component.html',
  styleUrls: ['./modify-combination.component.css']
})
export class ModifyCombinationComponent implements OnInit {
  combinationId;
  constructor(private  router: ActivatedRoute) { }

  ngOnInit() {
    this.combinationId = this.router.snapshot.paramMap.get('id');
  }

}
