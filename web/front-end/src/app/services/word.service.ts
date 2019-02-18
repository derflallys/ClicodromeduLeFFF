import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import {catchError, tap} from 'rxjs/operators';
import {Word} from '../models/Word';
import {environment} from '../../environments/environment';
import {IWord} from '../models/IWord';
import {Category} from '../models/Category';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json',
  })
};
@Injectable({
  providedIn: 'root'
})
export class WordService {
  private searchWordUrl = environment.BACK_END_URL + '/list/word';
  private addWordUrl = environment.BACK_END_URL + '/add/word';
  private updateWordUrl = environment.BACK_END_URL + '/update/word';
  private wordUrl = environment.BACK_END_URL + '/get/word';
  private categoryUrl = environment.BACK_END_URL + '/get/category';
  constructor(private http: HttpClient) { }

  getListWords(word: string): Observable<any> {
    return this.http.get<any>(this.searchWordUrl + '/' + word).pipe(
      tap(data => console.log('All: ' + JSON.stringify(data))),
      catchError(this.handleError)
    );
  }
  updateWord(word: IWord, id: number): Observable<Response> {
    return this.http.put<Response>(this.updateWordUrl + '/' + id, word, httpOptions )
      .pipe(
        catchError(this.handleError)
      )
      ;
  }

  addWordModified(word: IWord) {
    return this.http.post<Response>(this.addWordUrl, word, httpOptions )
      .pipe(
        catchError(this.handleError)
      );
  }

  getWord(id: number): Observable<Word> {
    return this.http.get<Word>(this.wordUrl + '/' + id, )
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
