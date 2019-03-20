import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-modify-combin',
  templateUrl: './modify-combin.component.html',
  styleUrls: ['./modify-combin.component.css']
})
export class ModifyCombinComponent implements OnInit {
  combinaisonId;
  constructor(private  router: ActivatedRoute) { }

  ngOnInit() {
    this.combinaisonId = this.router.snapshot.paramMap.get('id');
  }

}
