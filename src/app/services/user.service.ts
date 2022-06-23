import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { convertJSONToFormData } from '../common_fun';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  public apiURL = environment.API_URL;
  

  constructor(
    private httpClient : HttpClient
  ) { }

 

  CheckEmail(email:string):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/check_email',convertJSONToFormData({email:email}))
  }
  attemptLogin(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/login',convertJSONToFormData(data))
  }
  signup(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/signup',convertJSONToFormData(data))
  }

  
  socialLogin(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/socialLogin',convertJSONToFormData(data))
  }

  EditProfile(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/EditProfile',convertJSONToFormData(data))
  }

  ChangePassword(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/ChangePassword',convertJSONToFormData(data))
  }

  
  CreatePaymentIntent(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/CreatePaymentIntent',convertJSONToFormData(data))
  }

  
  MakeOrder(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/PlaceOrder',data)
  }

  MyOrders(data:any):Observable<any> {
    //let params = new HttpParams().set("user_id",user_id);

    let params = new HttpParams()

    for (const param in data) {
      params = params.set(param,data[param])
    }

    return this.httpClient.get<any>(this.apiURL + '/MyOrders/',{params})
      .pipe(
        catchError(this.errorHandler)
      )
  }

  GetCountry(data:any):Observable<any> {
    //let params = new HttpParams().set("user_id",user_id);

    let params = new HttpParams()

    for (const param in data) {
      params = params.set(param,data[param])
    }

    return this.httpClient.get<any>(this.apiURL + '/get_country/',{params})
      .pipe(
        catchError(this.errorHandler)
      )
  }

  MyAddress(data:any):Observable<any> {
    //let params = new HttpParams().set("user_id",user_id);

    let params = new HttpParams()

    for (const param in data) {
      params = params.set(param,data[param])
    }

    return this.httpClient.get<any>(this.apiURL + '/my_address/',{params})
      .pipe(
        catchError(this.errorHandler)
      )
  }
  AddAddress(data:any):Observable<any> {
    //let params = new HttpParams().set("user_id",user_id);

    return this.httpClient.post<any>(this.apiURL + '/add_address/',convertJSONToFormData(data))
      .pipe(
        catchError(this.errorHandler)
      )
  }
  EditAddress(data:any):Observable<any> {
    //let params = new HttpParams().set("user_id",user_id);

    return this.httpClient.post<any>(this.apiURL + '/edit_address/',convertJSONToFormData(data))
      .pipe(
        catchError(this.errorHandler)
      )
  }
  DeleteAddress(data:any):Observable<any> {
    //let params = new HttpParams().set("user_id",user_id);

    return this.httpClient.post<any>(this.apiURL + '/delete_address/',convertJSONToFormData(data))
      .pipe(
        catchError(this.errorHandler)
      )
  }

  MyTransactions(data:any):Observable<any> {
    let params = new HttpParams()

    for (const param in data) {
      params = params.set(param,data[param])
    }

    return this.httpClient.get<any>(this.apiURL + '/MyTransactions/',{params})
      .pipe(
        catchError(this.errorHandler)
      )
  }



  ForgetPassword(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/ForgetPassword',convertJSONToFormData(data))
  }
  ResetPassword(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/ResetPassword',convertJSONToFormData(data))
  }

  verifyToken(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL + '/verifyToken',convertJSONToFormData(data))
  }

  errorHandler(error:any){
    let errorMessage = '';
    if(error.error instanceof ErrorEvent){
      errorMessage = error.error.message
    } else {
      errorMessage = `Error Code: ${error.status}\n Message: ${error.message}`
    }
    return throwError(errorMessage)
  }
}
