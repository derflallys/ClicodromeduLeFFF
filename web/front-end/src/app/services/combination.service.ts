import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {catchError} from 'rxjs/operators';
import {Combinaison} from '../models/Combinaison';
import {Observable, throwError} from 'rxjs';
import {Category} from "../models/Category";

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
  private updateCombinaisonUrl = environment.BACK_END_URL + '/update/combinaison';
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
  updateCategory(combinaison: Combinaison, id: number) {
    return this.http.put<Response>(this.updateCombinaisonUrl + '/' + id, combinaison, httpOptions);
  }

}
