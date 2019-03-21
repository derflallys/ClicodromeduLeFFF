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
    this.http.get<Rule>(this.getRuleUrl + '/' + ruleId);
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
