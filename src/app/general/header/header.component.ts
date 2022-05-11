import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  myAlreadyItems: any = [];
  cartCount:number = 0;

  constructor() {}

  ngOnInit(): void {
    this.getCartCount();
  }

  getCartCount(){
    var alreadyItems = localStorage.getItem("cart");
    this.myAlreadyItems = alreadyItems;
    var alreadyItemsArr = JSON.parse(this.myAlreadyItems);
    this.cartCount = (alreadyItemsArr) ? alreadyItemsArr.length : 0;
  }
}
