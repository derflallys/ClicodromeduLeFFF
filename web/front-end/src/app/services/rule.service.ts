import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Rule} from '../models/Rule';
import {environment} from '../../environments/environment';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json',
  })
};
@Injectable({
  providedIn: 'root'
})
export class RuleService {

  private addRegleUrl = environment.BACK_END_URL + '/add/rule';
  private getRulesUrl = environment.BACK_END_URL + '/get/rules';
  private getRuleUrl = environment.BACK_END_URL + '/get/rule';
  private deleteRuleUrl = environment.BACK_END_URL + '/delete/rule';
  private updateRuleUrl = environment.BACK_END_URL + '/modify/rule';
  constructor(private http: HttpClient) { }

  addRegle(regle: Rule) {
    return this.http.post<Response>(this.addRegleUrl, regle, httpOptions  );
  }
  getAllRules(): Observable<Rule[]> {
    return this.http.get<Rule[]>(this.getRulesUrl);
  }
  getRule(ruleId: number) {
    return this.http.get<Rule>(this.getRuleUrl + '/' + ruleId);
  }
  deleteRule(ruleId: number) {
    return this.http.delete<Response>(this.deleteRuleUrl + '/' + ruleId);
  }

  updateRule(rule: Rule) {
    return this.http.put<Response>(this.updateRuleUrl + '/' + rule.id, rule, httpOptions);
  }
}
