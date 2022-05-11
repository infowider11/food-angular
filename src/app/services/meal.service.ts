import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators'
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class MealService {

  private apiURL = environment.API_URL;

  httpOptions:any = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json'
    })
  }



  constructor(private httpClient: HttpClient) { }

  getCategory(): Observable<any> {
    return this.httpClient.get<any>(this.apiURL + '/getCategory/')
      .pipe(
        catchError(this.errorHandler)
      )
  }

  
  getMealType(): Observable<any> {
    return this.httpClient.get<any>(this.apiURL + '/getMealType/')
      .pipe(
        catchError(this.errorHandler)
      )
  }
  
  getMeals(data:any): Observable<any> {
    //this.httpOptions["params"]=params;
    console.log(data)

    let params = new HttpParams()

    for (const param in data) {
      params = params.set(param,data[param])
    }

    return this.httpClient.get<any>(this.apiURL + '/getMeals/',{params})
      .pipe(
        catchError(this.errorHandler)
      )
  }

  getMealById(meal_id:any):Observable<any> {
    let params = new HttpParams().set("meal_id",meal_id);

    return this.httpClient.get<any>(this.apiURL + '/getMealById/',{params})
      .pipe(
        catchError(this.errorHandler)
      )
  }

  getPreferences(cat_id:any=''):Observable<any> {
    let params = new HttpParams().set("cat_id",cat_id);

    return this.httpClient.get<any>(this.apiURL + '/preferences/',{params})
      .pipe(
        catchError(this.errorHandler)
      )
  }


  getMealData(meal_ids:any=''):Observable<any> {
    let params = new HttpParams().set("meal_ids",meal_ids);

    return this.httpClient.get<any>(this.apiURL + '/getMealsDataForCart/',{params})
      .pipe(
        catchError(this.errorHandler)
      )
  }



  
  getAreaServed(): Observable<any> {
    return this.httpClient.get<any>(this.apiURL + '/getAreaServed/')
      .pipe(
        catchError(this.errorHandler)
      )
  }

  
  getAreaServedById(area_group:any=1): Observable<any> {



    return this.httpClient.get<any>(this.apiURL + '/getAreaServedById/?area_group='+area_group)
      .pipe(
        catchError(this.errorHandler)
      )
  }

  errorHandler(error: any) {
    let errorMessage = '';
    if (error.error instanceof ErrorEvent) {
      errorMessage = error.error.message;
    } else {
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    return throwError(errorMessage);
  }
}
