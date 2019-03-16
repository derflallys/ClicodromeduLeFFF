import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import {catchError, tap} from 'rxjs/operators';
import {Regle} from '../models/Regle';
import {environment} from '../../environments/environment';
import {Category} from '../models/Category';


const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json',
  })
};
@Injectable({
  providedIn: 'root'
})
export class RegleService {

  private addRegleUrl = environment.BACK_END_URL + '/add/addrule';
  private categoryUrl = environment.BACK_END_URL + '/get/category';
  constructor(private http: HttpClient) { }

  addRegle(regle: Regle) {
    return this.http.post<Response>(this.addRegleUrl, regle, httpOptions  )
        .pipe(
            catchError(this.handleError)
        );
  }
  getCategories(): Observable<Category[]> {
    return this.http.get<Category[]>(this.categoryUrl )
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
