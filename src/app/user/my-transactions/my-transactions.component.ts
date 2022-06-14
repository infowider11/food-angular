import { Component, OnInit } from '@angular/core';
import { UserService } from 'src/app/services/user.service';
import { AuthService } from 'src/app/services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-my-transactions',
  templateUrl: './my-transactions.component.html',
  styleUrls: ['./my-transactions.component.css']
})
export class MyTransactionsComponent implements OnInit {

  transactions:any=[]

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
    this.userService.MyTransactions(this.AuthService.userdata.id).subscribe((data:any)=>{
      if(data.status==1 && data.data.length > 0){
        this.transactions = data.data
        console.log('transactions',this.transactions);
      }
    })
  }

}
