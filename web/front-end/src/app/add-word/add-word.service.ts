import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse} from '@angular/common/http';
import {throwError} from 'rxjs';
import {Word} from '../Word';
import {catchError, tap} from 'rxjs/operators';
@Injectable({
  providedIn: 'root'
})
export class AddWordService {

  constructor(private http: HttpClient) { }
  WordUrl = '#';

  addWord(word: Word) {
    return this.http.post<Word>(this.WordUrl, word )
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
