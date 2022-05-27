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

  ForgetPassword(data:any):Observable<any>{
    return this.httpClient.post<any>(this.apiURL+'/ForgetPassword',convertJSONToFormData(data))
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
