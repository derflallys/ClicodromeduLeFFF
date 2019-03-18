import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import {catchError, tap} from 'rxjs/operators';
import {Word} from '../models/Word';
import {environment} from '../../environments/environment';
import {Category} from '../models/Category';
import {IWord} from '../models/IWord';

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
  private wordWithoutFormsUrl = environment.BACK_END_URL + '/get/wordWithoutForms';
  private categoryUrl = environment.BACK_END_URL + '/get/category';
  constructor(private http: HttpClient) { }

  getListWords(word: string): Observable<any> {
    return this.http.get<any>(this.searchWordUrl + '/' + word);
  }
  updateWord(word: Word, id: number) {
    return this.http.put<Response>(this.updateWordUrl + '/' + id, word, httpOptions);
  }

  addWord(word: IWord) {
    return this.http.post<Response>(this.addWordUrl, word, httpOptions);
  }

  getWord(id): Observable<Word> {
    return this.http.get<Word>(this.wordUrl + '/' + id);
  }

  getWordWithoutInflectedForms(id): Observable<Word> {
    return this.http.get<Word>(this.wordWithoutFormsUrl + '/' + id);
  }

  getCategories(): Observable<Category[]> {
    return this.http.get<Category[]>(this.categoryUrl);
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
