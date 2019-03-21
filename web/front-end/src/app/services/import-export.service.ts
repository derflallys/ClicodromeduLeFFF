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
  private importUrlCustom = environment.BACK_END_URL + '/import/custom';
  private importUrlTxt = environment.BACK_END_URL + '/import/txt';
  private importUrlMlex = environment.BACK_END_URL + '/import/mlex';
  private exportUrl = environment.BACK_END_URL + '/export';

  constructor(private http: HttpClient) {}
  sendFileToImport(file: any) {
    return this.http.post<Response>(this.importUrlCustom, file, httpOptions);
  }
  importSyntaxCustom() {
    return this.http.get<Response>(this.importUrlCustom);
  }
  importSyntaxTxt() {
    return this.http.get<Response>(this.importUrlTxt);
  }
  importSyntaxMlex() {
    return this.http.get<Response>(this.importUrlMlex);
  }
  doExport() {
    return this.http.get(this.exportUrl, {
      headers: {
        'Content-Type': 'text/plain; charset=utf-8',
        'Cache-Control': 'no-cache',
      }, responseType: 'blob'
    });
  }
}
