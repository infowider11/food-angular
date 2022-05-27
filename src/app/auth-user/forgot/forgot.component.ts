import { Component, OnInit } from '@angular/core';
import { ComingSoon } from 'src/app/common_fun';
import { AuthService } from 'src/app/services/auth.service';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-forgot',
  templateUrl: './forgot.component.html',
  styleUrls: ['./forgot.component.css']
})
export class ForgotComponent implements OnInit {

  ComingSoon:any=ComingSoon
  form!: FormGroup;
  is_loading:boolean= false;

  login_error_message:string = '';
  login_success_message:string = '';

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
      email: new FormControl('', [Validators.required, Validators.email])
    })
  }
  

  ngOnInit(): void {
  }

  forgot() {

    this.is_loading = true;
    console.log('1', this.form.value);


    this.userService.ForgetPassword(this.form.value).subscribe((data: any) => {
      console.log('contact form', data);
      this.login_error_message = '';
      this.is_loading = false;

      if(data.status==1){

        this.login_success_message = data.message;
        
        this.login_error_message='';

        this.form = new FormGroup({
          email: new FormControl('', [Validators.required, Validators.email])
        })

        setTimeout(()=>{
          this.login_success_message = '';
        },3000)
    
      } else {
        this.login_error_message=data.message;
      }
      
    })
  }

}
