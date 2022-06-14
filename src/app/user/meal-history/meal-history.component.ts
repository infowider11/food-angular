import { Component, OnInit } from '@angular/core';
import { UserService } from 'src/app/services/user.service';
import { AuthService } from 'src/app/services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-meal-history',
  templateUrl: './meal-history.component.html',
  styleUrls: ['./meal-history.component.css']
})
export class MealHistoryComponent implements OnInit {

  orders:any=[]

  constructor(
    private router: Router,
    public AuthService:AuthService,
    private userService:UserService
  ) {
    if(!this.AuthService.is_user_logged_in){
      this.router.navigate(['/login']);
      return
    }
  }

  ngOnInit(): void {
    this.userService.MyOrders(this.AuthService.userdata.id).subscribe((data:any)=>{
      if(data.status==1 && data.data.length > 0){
        this.orders = data.data
        console.log('transactions',this.orders);
      }
    })
  }

}
