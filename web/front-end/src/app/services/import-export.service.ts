import { Injectable } from '@angular/core';
import {Observable} from 'rxjs';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {environment} from '../../environments/environment';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'text/plain',
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
  importSyntaxCustom(fileToUpload: File) {
    const formData: FormData = new FormData();
    formData.append('fileKey', fileToUpload, fileToUpload.name);
    return this.http.post(this.importUrlCustom, formData, {headers: {'Content-Type':  fileToUpload.type} });
  }
  importSyntaxTxt(fileToUpload: File) {
    const formData: FormData = new FormData();
    formData.append('fileKey', fileToUpload, fileToUpload.name);
    return this.http.post(this.importUrlTxt, formData, {headers: {'Content-Type':  fileToUpload.type} });
  }
  importSyntaxMlex(fileToUpload: File) {
    const formData: FormData = new FormData();
    formData.append('fileKey', fileToUpload, fileToUpload.name);
    return this.http.post(this.importUrlMlex, formData, {headers: {'Content-Type':  fileToUpload.type} });
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
