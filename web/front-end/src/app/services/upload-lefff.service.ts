import { Injectable } from '@angular/core';
import {Observable, of, throwError} from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json',
    // 'Authorization': 'my-auth-token'
  })
};

@Injectable({
  providedIn: 'root'
})

export class UploadLefffService {
  lefffUrl = 'UrlAPIVERSLESERVEUR';
  constructor(private httpClient: HttpClient) { }

  postFile(lefff: any) {
    return this.httpClient.post(this.lefffUrl, lefff, httpOptions)
      .pipe(
        catchError(this.handleError)
      );
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
