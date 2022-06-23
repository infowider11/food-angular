import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-dashbord',
  templateUrl: './dashbord.component.html',
  styleUrls: ['./dashbord.component.css']
})
export class DashbordComponent implements OnInit {

  form!: FormGroup;
  is_loading:boolean= false;
  login_error_message:string = '';
  login_success_message:string = '';
  country:any = [];

  constructor(
    private router: Router,
    public AuthService:AuthService,
    private userService:UserService,
  ) { 
    if(!this.AuthService.is_user_logged_in){
      this.router.navigate(['/login']);
    }

    this.form = new FormGroup({
      email: new FormControl(this.AuthService.userdata.email, [Validators.required, Validators.email]),
      name: new FormControl(this.AuthService.userdata.name,[Validators.required]),
      phone: new FormControl(this.AuthService.userdata.phone,[Validators.required,Validators.pattern('[- +()0-9]+')]),
      alternate_number: new FormControl(this.AuthService.userdata.alternate_number,[Validators.required,Validators.pattern('[- +()0-9]+')]),
      country: new FormControl(this.AuthService.userdata.country,[Validators.required])
    })
  }

  ngOnInit(): void {
    this.userService.GetCountry({}).subscribe((data:any)=>{
      if(data.status = 1){
        this.country = data.data
        console.log(this.country)
      }
    })
  }

  editProfile() {

    this.is_loading = true;
    console.log('1', this.form.value);

    this.form.value.user_id = this.AuthService.userdata.id;
    
    this.userService.EditProfile(this.form.value).subscribe((data: any) => {
      console.log('edit_profile form', data);
      this.login_error_message = '';
      this.is_loading = false;

      if(data.status==1){

        this.login_success_message = data.message;
        
        this.AuthService.authorization(data.data)
        this.login_error_message='';

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
