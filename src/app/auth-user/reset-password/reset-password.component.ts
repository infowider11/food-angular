import { Component, OnInit } from '@angular/core';
import { UserService } from 'src/app/services/user.service';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.css']
})
export class ResetPasswordComponent implements OnInit {

  form!: FormGroup;
  is_loading:boolean= false;
  page_message:any = '';
  show_form:boolean=false;
  id:any='';
  token:any=''
  

  constructor(
    public userService:UserService,
    public actRoute: ActivatedRoute
  ) {

    this.actRoute.queryParams.subscribe(params => {
      console.log(params)
      this.id = params['id'];
      this.token = params['token'];
  });

    this.page_message = '<div class="alert alert-warning"><i class="fa fa-spin fa-spinner"></i> Validating your token. </div>';

    this.form = new FormGroup({
      password: new FormControl('', [Validators.required, Validators.minLength(6)]),
      confirm_password: new FormControl('', [Validators.required, Validators.minLength(6)]),
    })
  }

  ngOnInit(): void {

    let data = {
      id:this.id,
      token:this.token
    }

    this.userService.verifyToken(data).subscribe((data: any) => {
      console.log(data);

      if (data.status == 1) {
        this.show_form=true;
        this.page_message = '';

      } else {

        this.page_message = '<div class="alert alert-danger">'+data.message+'</div>';
        this.show_form=false;

      }


    })
  }

  reset_password() {

    this.is_loading = true;
    console.log('1', this.form.value);


    if(this.form.value.password != this.form.value.confirm_password) {
      this.page_message = '<div class="alert alert-warning">Confirm password not matched with new Password field</div>'
      this.is_loading = false;
      return
    }
    this.is_loading = true;

    this.form.value.id = this.id;
    this.form.value.token=this.token


    this.userService.ResetPassword(this.form.value).subscribe((data: any) => {
      console.log('contact form', data);
      this.page_message = '';
      this.is_loading = false;

      if(data.status==1){

        this.page_message = '<div class="alert alert-success">'+data.message+'</div>';
        
        this.form = new FormGroup({
          password: new FormControl('', [Validators.required, Validators.minLength(6)]),
          confirm_password: new FormControl('', [Validators.required, Validators.minLength(6)]),
        })
      } else {

        this.page_message = '<div class="alert alert-danger">'+data.message+'</div>';
        
      }

      this.show_form=false;
      
    })
  }

}
