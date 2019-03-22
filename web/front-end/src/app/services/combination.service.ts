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
  private getCombinaisonsUrl = environment.BACK_END_URL + '/get/combinaisons';
  private getCombinaisonUrl = environment.BACK_END_URL + '/get/combinaison';
  private addCombinUrl = environment.BACK_END_URL + '/add/combinaison';
  private deleteCombinaisonUrl = environment.BACK_END_URL + '/delete/combinaison';
  private updateCombinaisonUrl = environment.BACK_END_URL + '/update/combinaison';
  constructor(private http: HttpClient) { }
  getCombinaisonByCategory(idCategory): Observable<Combinaison[]> {
    return this.http.get<Combinaison[]>(this.getCombinaisonsUrl + '/' + idCategory);
  }

  getCombinaison(idCombinaison) {
    return this.http.get<Combinaison>(this.getCombinaisonUrl + '/' + idCombinaison);
  }

  addCombinaison( combinaison: Combinaison) {
    return this.http.post<Response>(this.addCombinUrl, combinaison, httpOptions  );
  }
  deleteCombinaison(id: number) {
    return this.http.delete<Response>(this.deleteCombinaisonUrl + '/' + id);
  }
  updateCombinaison(combinaison: Combinaison, id: number) {
    return this.http.put<Response>(this.updateCombinaisonUrl + '/' + id, combinaison, httpOptions);
  }

}
