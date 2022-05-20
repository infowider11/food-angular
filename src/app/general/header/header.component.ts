import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';
import { CartService } from 'src/app/services/cart.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  myAlreadyItems: any = [];

  constructor(
    public cartService:CartService,
    public AuthService:AuthService
  ) {}

  ngOnInit(): void {
    
  }

}
