import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import {Word} from '../models/Word';
import {environment} from '../../environments/environment';
import {IWord} from '../models/IWord';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json',
  })
};
@Injectable({
  providedIn: 'root'
})
// les methotes du service sont asynchrones
export class WordService {
  private searchWordUrl = environment.BACK_END_URL + '/list/word';
  private addWordUrl = environment.BACK_END_URL + '/add/word';
  private updateWordUrl = environment.BACK_END_URL + '/update/word';
  private wordUrl = environment.BACK_END_URL + '/get/word';
  private wordWithoutFormsUrl = environment.BACK_END_URL + '/get/wordWithoutForms';
  private deleteWordUrl = environment.BACK_END_URL + '/delete/word';
  constructor(private http: HttpClient) { }
  // method pour avoir la liste des mots du lefff en utilisant la methode http get
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
  // permet d'avoir les informations d'un mot sans ces formes fléchies
  getWordWithoutInflectedForms(id): Observable<Word> {
    return this.http.get<Word>(this.wordWithoutFormsUrl + '/' + id);
  }
  deleteWord(id: number) {
    return this.http.delete<Response>(this.deleteWordUrl + '/' + id);
  }
}
