import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class CommonServiceService {

  private apiURL = environment.API_URL;

  httpOptions = new HttpHeaders().set('Content-Type','application/json')
  

  constructor(private httpClient: HttpClient) { }

  getHomePageContent(): Observable<any> {
    return this.httpClient.get<any>(this.apiURL + '/getHomePageContent')
      .pipe(
        catchError(this.errorHandler)
      )
  }

  getAboutPageContent(): Observable<any> {
    return this.httpClient.get<any>(this.apiURL + '/getAboutPageContent')
      .pipe(
        catchError(this.errorHandler)
      )
  }

  getTermsPageContent(): Observable<any> {
    return this.httpClient.get<any>(this.apiURL + '/getTermsPageContent')
      .pipe(
        catchError(this.errorHandler)
      )
  }

  getPrivacyPageContent(): Observable<any> {
    return this.httpClient.get<any>(this.apiURL + '/getPrivacyPageContent')
      .pipe(
        catchError(this.errorHandler)
      )
  }

  getFooterContent(): Observable<any> {
    return this.httpClient.get<any>(this.apiURL + '/getFooterContent')
      .pipe(
        catchError(this.errorHandler)
      )
  }

  convertJSONToFormData(params:any){
      let n = new FormData();
      for(let key in params){
        n.append(key,params[key])
      }
      return n;
  }

  contactForSameDay(data:any): Observable<any> {
    return this.httpClient.post<any>(this.apiURL + '/contactForSameDay',this.convertJSONToFormData(data))
      .pipe(
        catchError(this.errorHandler)
      )
  }



  errorHandler(error: any) {
    let errorMessage = '';
    if (error.error instanceof ErrorEvent) {
      errorMessage = error.error.message
    } else {
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    return throwError(errorMessage);
  }
}
