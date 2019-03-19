import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {catchError} from 'rxjs/operators';
import {Combinaison} from '../models/Combinaison';
import {Observable, throwError} from 'rxjs';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json',
  })
};
@Injectable({
  providedIn: 'root'
})
export class RulesService {
  private addCombinUrl = environment.BACK_END_URL + '/add/combinaison';
  private categoryUrl = environment.BACK_END_URL + '/get/category';
  constructor(private http: HttpClient) { }
  addCombinaison(combinaison: Combinaison) {
    return this.http.post<Response>(this.addCombinUrl, combinaison, httpOptions  )
        .pipe(
            catchError(this.handleError)
        );
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
