import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';

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
    return this.http.post(this.importUrlCustom, formData, {headers: {'Content-Type':  fileToUpload.type, 'Cache-Control': 'no-cache'} });
  }
  importSyntaxTxt(fileToUpload: File) {
    const formData: FormData = new FormData();
    formData.append('fileKey', fileToUpload, fileToUpload.name);
    return this.http.post(this.importUrlTxt, formData, {headers: {'Content-Type':  fileToUpload.type, 'Cache-Control': 'no-cache'} });
  }
  importSyntaxMlex(fileToUpload: File) {
    const formData: FormData = new FormData();
    formData.append('fileKey', fileToUpload, fileToUpload.name);
    return this.http.post(this.importUrlMlex, formData, {headers: {'Content-Type':  fileToUpload.type, 'Cache-Control': 'no-cache'} });
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
