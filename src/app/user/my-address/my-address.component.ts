import { Component, OnInit } from '@angular/core';
import { UserService } from 'src/app/services/user.service';
import { AuthService } from 'src/app/services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-my-address',
  templateUrl: './my-address.component.html',
  styleUrls: ['./my-address.component.css']
})
export class MyAddressComponent implements OnInit {

  addresses:any=[]

  constructor(private router: Router,
    public AuthService: AuthService,
    private userService: UserService
  ) {
    if (!this.AuthService.is_user_logged_in) {
      this.router.navigate(['/login']);
      return
    }
  }

  ngOnInit(): void {
    this.userService.MyAddress(this.AuthService.userdata.id).subscribe((data:any)=>{
      if(data.status==1 && data.data.length > 0){
        this.addresses = data.data
        console.log('addresses',this.addresses);
      }
    })
  }

}
