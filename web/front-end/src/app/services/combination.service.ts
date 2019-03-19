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
export class CombinationService {
  private getCombinaisonUrl = environment.BACK_END_URL + '/get/combinaison';
  private addCombinUrl = environment.BACK_END_URL + '/add/combinaison';
  private deleteCombinaisonUrl = environment.BACK_END_URL + '/delete/combinaison';
  constructor(private http: HttpClient) { }
  getCombinaison(id): Observable<Combinaison[]> {
    return this.http.get<Combinaison[]>(this.getCombinaisonUrl + '/' + id);
  }

  addCombinaison( combinaison: Combinaison) {
    return this.http.post<Response>(this.addCombinUrl, combinaison, httpOptions  );
  }
  deleteCombinaison(id: number) {
    return this.http.delete<Response>(this.deleteCombinaisonUrl + '/' + id);
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
