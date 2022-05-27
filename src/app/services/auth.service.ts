import { Injectable } from '@angular/core';
import { UserService } from './user.service';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  is_user_logged_in:boolean = false;
  userdata:any=false

  constructor(
    private userService:UserService
  ) {
    var alreadyItems = localStorage.getItem("user-auth");
    this.userdata = (alreadyItems) ? JSON.parse(alreadyItems) : false;
    this.is_user_logged_in = (this.userdata) ? true : false;
   }

   attemptLogin(data:any){
    this.userService.attemptLogin(data).subscribe((data:any)=>{
      console.log('login data',data);
    
      if(data.status==1){

        this.userdata = data.data
        this.is_user_logged_in=true;
        localStorage.setItem("user-auth", JSON.stringify(this.userdata));
        
      } else {
        this.userdata = false
        this.is_user_logged_in=false;

      }

      return data
      
    })
   }

   authorization(data:any){
    console.log('login data',data);
    this.userdata = data
    this.is_user_logged_in=true;
    localStorage.setItem("user-auth", JSON.stringify(this.userdata));

      return data
      
    
   }

   updateUserData(data:any){
   
    this.userdata = data
    this.is_user_logged_in=true;
    localStorage.setItem("user-auth", JSON.stringify(this.userdata));

      return data
      
    
   }

   logout(){
    localStorage.clear();
    this.is_user_logged_in = false;
    this.userdata = false;
   }

}
