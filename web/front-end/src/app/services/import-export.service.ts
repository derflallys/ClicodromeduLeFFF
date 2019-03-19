import { Injectable } from '@angular/core';
import {Observable} from 'rxjs';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {environment} from '../../environments/environment';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json',
  })
};

@Injectable({
  providedIn: 'root'
})
export class ImportExportService {
  private importUrl = environment.BACK_END_URL + '/import';

  constructor(private http: HttpClient) {}
  sendFileToImport(file: any) {
    return this.http.post<Response>(this.importUrl, file, httpOptions);
  }
}
