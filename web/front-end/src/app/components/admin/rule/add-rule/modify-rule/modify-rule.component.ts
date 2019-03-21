import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';

@Component({
  selector: 'app-modify-rule',
  templateUrl: './modify-rule.component.html',
  styleUrls: ['./modify-rule.component.css']
})
export class ModifyRuleComponent implements OnInit {
  ruleId;
  constructor(private  router: ActivatedRoute) { }

  ngOnInit() {
    this.ruleId = this.router.snapshot.paramMap.get('id');
  }

}
