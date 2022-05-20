import { Component, OnInit } from '@angular/core';
import { ComingSoon } from 'src/app/common_fun';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { CartService } from 'src/app/services/cart.service';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent implements OnInit {

  ComingSoon:any=ComingSoon

  constructor(
    public cartService: CartService,
    private router: Router,
    public AuthService:AuthService
  ) { 
    if(!this.AuthService.is_user_logged_in){
      this.router.navigate(['/login']);
    }
  }

  ngOnInit(): void {
  }

  logout(){
    if(confirm('Are you sure?')){
      localStorage.clear();
      this.cartService.clearCart();
      this.AuthService.logout()
      this.router.navigate(['/login']);
    }
  }

}
