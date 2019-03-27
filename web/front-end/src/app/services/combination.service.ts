import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {Combination} from '../models/Combination';

const httpOptions = {
    headers: new HttpHeaders({
        'Content-Type':  'application/json',
    })
};
@Injectable({
    providedIn: 'root'
})
export class CombinationService {
    private getAllUrl = environment.BACK_END_URL + '/get/combinations';
    private getCombinationUrl = environment.BACK_END_URL + '/get/combination';
    private addCombinationUrl = environment.BACK_END_URL + '/add/combination';
    private updateCombinationUrl = environment.BACK_END_URL + '/update/combination';
    private deleteCombinationUrl = environment.BACK_END_URL + '/delete/combination';
    constructor(private http: HttpClient) { }
    getAllCombinations() {
        return this.http.get<Combination[]>(this.getAllUrl, httpOptions);
    }
    getCombination(idCombination) {
        return this.http.get<Combination>(this.getCombinationUrl + '/' + idCombination);
    }
    addCombination(combination: Combination) {
        return this.http.post<Response>(this.addCombinationUrl, combination, httpOptions  );
    }
    updateCombination(combination: Combination, id: number) {
        return this.http.put<Response>(this.updateCombinationUrl + '/' + id, combination, httpOptions);
    }
    deleteCombination(id: number) {
        return this.http.delete<Response>(this.deleteCombinationUrl + '/' + id);
    }
}
