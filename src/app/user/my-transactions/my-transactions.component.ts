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
  start_date:any='';
  end_date:any='';
  status:any="";
  loading:boolean=false;
  searchData:any={}

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
    this.getTransactionHitroy();
  }

  searchFn(){
    this.getTransactionHitroy();
  }
  reset(){
    this.start_date = '';
    this.end_date = '';
    this.status = '';
    this.getTransactionHitroy();
  }
  

  getTransactionHitroy(){
    this.loading = true;

    this.searchData= {
      user_id:this.AuthService.userdata.id
    }

    if(this.start_date){
      this.searchData["start_date"] = this.start_date
    }
    if(this.end_date){
      this.searchData["end_date"] = this.end_date
    }
    
    if(this.status){
      this.searchData["status"] = this.status
    }

    this.userService.MyTransactions(this.searchData).subscribe((data:any)=>{
      if(data.status==1){
        this.transactions = data.data
   
        
      }
      this.loading = false;
    })
  }

}
