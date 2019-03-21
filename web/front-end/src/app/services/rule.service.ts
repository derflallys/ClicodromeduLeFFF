import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import {catchError, tap} from 'rxjs/operators';
import {Rule} from '../models/Rule';
import {environment} from '../../environments/environment';
import {Category} from "../models/Category";

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
  private getRulesCategoryUrl = environment.BACK_END_URL + '/get/rulesByCategory';
  private deleteRuleUrl = environment.BACK_END_URL + '/delete/rule';
  private updateRuleUrl = environment.BACK_END_URL + '/modify/rule';
  constructor(private http: HttpClient) { }

  addRegle(regle: Rule) {
    return this.http.post<Response>(this.addRegleUrl, regle, httpOptions  );
  }
  getAllRules(): Observable<Rule[]> {
    return this.http.get<Rule[]>(this.getRulesUrl);
  }
  getRulesByCategory(categoryId: number): Observable<Rule[]> {
    return this.http.get<Rule[]>(this.getRulesCategoryUrl + '/' + categoryId);
  }
  getRule(ruleId: number) {
    return this.http.get<Rule>(this.getRuleUrl + '/' + ruleId);
  }
  deleteRule(ruleId: number) {
    return this.http.delete<Response>(this.deleteRuleUrl + '/' + ruleId);
  }

  updateRule(rule: Rule, id: number) {
    return this.http.put<Response>(this.updateRuleUrl + '/' + id, rule, httpOptions);
  }

  private handleError(err: HttpErrorResponse) {
    let errorMessage = '';
    if (err.error instanceof ErrorEvent) {
      errorMessage = `An  error occured: ${err.error.message}`;
    } else {
      errorMessage = `Server returned code: ${err.status}, error message is: ${err.message}`;
    }
    console.error(errorMessage);
    return throwError(errorMessage);
  }
}
