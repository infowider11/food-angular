import { Component, OnInit } from '@angular/core';
import { ComingSoon } from 'src/app/common_fun';
import { AuthService } from 'src/app/services/auth.service';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {

  ComingSoon:any=ComingSoon
  form!: FormGroup;
  is_loading:boolean= false;

  login_error_message:string = '';

  constructor(
    private router: Router,
    public AuthService:AuthService,
    private userService:UserService,
  ) {
    if(this.AuthService.is_user_logged_in){
      this.router.navigate(['/dashboard']);
      return
    }

    this.form = new FormGroup({
      email: new FormControl('', [Validators.required, Validators.email]),
      password: new FormControl('',[Validators.required]),
      name: new FormControl('',[Validators.required]),
      confirm_password: new FormControl('',[Validators.required]),
    })
  }
  

  ngOnInit(): void {
  }

  signup() {

    this.is_loading = true;
    console.log('1', this.form.value);


    if(this.form.value.password != this.form.value.confirm_password) {
      this.login_error_message = "Confirm password not matched with new Password field"
      this.is_loading = false;
      return
    }
    this.is_loading = true;

    this.userService.signup(this.form.value).subscribe((data: any) => {
      console.log('contact form', data);
      this.login_error_message = '';
      this.is_loading = false;

      if(data.status==1){
        
        this.AuthService.authorization(data.data)
        this.login_error_message='';
        this.router.navigate(['/dashboard']);
      } else {
        this.login_error_message=data.message;
      }
      
    })
  }

}
