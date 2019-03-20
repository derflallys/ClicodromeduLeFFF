import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';

@Component({
  selector: 'app-modify-category',
  templateUrl: './modify-category.component.html',
  styleUrls: ['./modify-category.component.css']
})
export class ModifyCategoryComponent implements OnInit {
  categoryId;
  constructor(private  router: ActivatedRoute) { }

  ngOnInit() {
    this.categoryId = this.router.snapshot.paramMap.get('id');
  }

}
