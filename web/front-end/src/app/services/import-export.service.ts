import { Injectable } from '@angular/core';
import {Observable} from 'rxjs';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {environment} from '../../environments/environment';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json',
  })
};
const headers = new HttpHeaders().set('Content-Type', 'text/plain; charset=utf-8');


@Injectable({
  providedIn: 'root'
})
export class ImportExportService {
  private importUrl = environment.BACK_END_URL + '/import';
  private exportUrl = environment.BACK_END_URL + '/export';

  constructor(private http: HttpClient) {}
  sendFileToImport(file: any) {
    return this.http.post<Response>(this.importUrl, file, httpOptions);
  }
  doExport() {
    return this.http.get(this.exportUrl, { headers, responseType: 'text'});
  }
}
