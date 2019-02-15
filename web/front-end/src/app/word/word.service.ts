import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import {catchError, tap} from 'rxjs/operators';
import {Word} from './Word';
import {environment} from '../../environments/environment';
import {IWord} from './IWord';

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

  getListWords(word: string): Observable<IWord[]> {
    return this.http.get<IWord[]>(this.searchWordUrl + '/' + word)/*.pipe(
      tap(data => console.log('All: ' + JSON.stringify(data))),
      catchError(this.handleError)
    )*/;
  }
  updateWord(word: Word) {
    return this.http.put<Word>(this.updateWordUrl + '/' + word, httpOptions )
      .pipe(
        catchError(this.handleError)
      );
  }

  addWordModified(word: any) {
    return this.http.post<any>(this.addWordUrl, word, httpOptions )
      .pipe(
        catchError(this.handleError)
      );
  }

  getWord(id: string) {
    return this.http.get<Word>(this.wordUrl + '/' + id, )
      .pipe(
        catchError(this.handleError)
      );
  }

  getcategories() {
    return this.http.get<any>(this.categoryUrl )
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
