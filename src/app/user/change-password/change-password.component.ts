import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-change-password',
  templateUrl: './change-password.component.html',
  styleUrls: ['./change-password.component.css']
})
export class ChangePasswordComponent implements OnInit {

  form!: FormGroup;
  is_loading:boolean= false;
  login_error_message:string = '';
  login_success_message:string = '';

  constructor(
    private router: Router,
    public AuthService:AuthService,
    private userService:UserService,
  ) { 
    if(!this.AuthService.is_user_logged_in){
      this.router.navigate(['/login']);
    }

    this.form = new FormGroup({
      current_password: new FormControl('', [Validators.required]),
      password: new FormControl('', [Validators.required, Validators.minLength(6)]),
      confirm_password: new FormControl('', [Validators.required, Validators.minLength(6)]),
    })
  }

  ngOnInit(): void {
  }

  changePassword() {

    this.is_loading = true;
    console.log('1', this.form.value);


    if(this.form.value.password != this.form.value.confirm_password) {
      this.login_error_message = "Confirm password not matched with new Password field"
      this.is_loading = false;
      return
    }
    this.is_loading = true;

    
    this.form.value.user_id = this.AuthService.userdata.id;
    
    this.userService.ChangePassword(this.form.value).subscribe((data: any) => {
      console.log('edit_profile form', data);
      this.login_error_message = '';
      this.is_loading = false;

      if(data.status==1){

        this.login_success_message = data.message;
        
        this.login_error_message='';

        this.form = new FormGroup({
          current_password: new FormControl('', [Validators.required]),
          password: new FormControl('', [Validators.required, Validators.minLength(6)]),
          confirm_password: new FormControl('', [Validators.required, Validators.minLength(6)]),
        })

        setTimeout(()=>{
          this.login_success_message = '';
        },3000)

        //this.router.navigate(['/dashboard']);
      } else {
        this.login_error_message=data.message;
      }
      
    })
  }

}
