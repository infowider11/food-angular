import { Component, OnInit } from '@angular/core';
import { UserService } from 'src/app/services/user.service';
import { AuthService } from 'src/app/services/auth.service';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';

declare var window: any;

@Component({
  selector: 'app-my-address',
  templateUrl: './my-address.component.html',
  styleUrls: ['./my-address.component.css']
})
export class MyAddressComponent implements OnInit {

  addresses:any=[]
  form!: FormGroup;
  form2!: FormGroup;
  show_edit:boolean =false;

  constructor(private router: Router,
    public AuthService: AuthService,
    private userService: UserService,
  ) {
    if (!this.AuthService.is_user_logged_in) {
      this.router.navigate(['/login']);
      return
    }
  }

  ngOnInit(): void {
    this.getMyAdress();
    this.add_address_form();
    this.edit_address_form({
      delivery_title:'',id:'',delivery_name:'',delivery_phone:'',delivery_email:'',delivery_address:'',delivery_remark:''
    });
  }

  add_address_form() {

    this.form = new FormGroup({
      user_id: new FormControl(this.AuthService.userdata.id, [Validators.required]),
      delivery_title: new FormControl('', [Validators.required]),
      delivery_name: new FormControl('', [Validators.required]),
      delivery_phone: new FormControl('', [Validators.required, Validators.pattern('[- +()0-9]+')]),
      delivery_email: new FormControl('', [Validators.required, Validators.email]),
      delivery_address: new FormControl('', [Validators.required]),
      delivery_remark: new FormControl(''),
    })

  }
  edit_address_form(data:any) {

    this.form2 = new FormGroup({
      user_id: new FormControl(this.AuthService.userdata.id, [Validators.required]),
      delivery_title: new FormControl(data.delivery_title, [Validators.required]),
      id: new FormControl(data.id, [Validators.required]),
      delivery_name: new FormControl(data.delivery_name, [Validators.required]),
      delivery_phone: new FormControl(data.delivery_phone, [Validators.required, Validators.pattern('[- +()0-9]+')]),
      delivery_email: new FormControl(data.delivery_email, [Validators.required, Validators.email]),
      delivery_address: new FormControl(data.delivery_address, [Validators.required]),
      delivery_remark: new FormControl(data.delivery_remark),
    })

  }

  OpenEditAddress(data:any){
    this.show_edit = true;
    console.log('k',data);
    
    this.edit_address_form(data);
    new window.bootstrap.Modal(
      document.getElementById('edit-address')
    ).show();
  }

  submit_edit_address_form(){
    this.userService.EditAddress(this.form2.value).subscribe((data: any) => {
      if (data.status == 1) {
        
        alert(data.message);

       
        

        this.getMyAdress();
        this.add_address_form();


        
        
      } else {
        alert(data.message)
      }
    })

  }

  submit_add_address_form(){
    this.userService.AddAddress(this.form.value).subscribe((data: any) => {
      if (data.status == 1) {

        alert(data.message);

        this.getMyAdress();
        this.add_address_form();

        
      } else {
        alert(data.message)
      }
    })
  }

  deleteAddress(id:number,i:number){
    if(confirm('Are you sure?')){
      this.userService.DeleteAddress({user_id:this.AuthService.userdata.id,id:id}).subscribe((data:any)=>{
        alert(data.message);
        if(data.status==1){

          
            this.addresses.splice(i, 1); // 2nd parameter means remove one item only
          

        }
      })
    }
  }

  getMyAdress(){
    const data = {
      user_id:this.AuthService.userdata.id
    }
    this.userService.MyAddress(data).subscribe((data:any)=>{
      if(data.status==1 && data.data.length > 0){
        this.addresses = data.data
        console.log('addresses',this.addresses);
      }
    })
  }

}
