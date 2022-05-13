import { Injectable, } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CartService {

  items: any = [];

  constructor() { 
    var alreadyItems = localStorage.getItem("cart");
    this.items = (alreadyItems) ? JSON.parse(alreadyItems) : [];
  
  }

  
  /* . . . */



  addToCart(product:any) {

    
   
    if (this.items.length > 0) {
      this.items = this.items.filter((data: any) => {
        if (data.id !== product.id) {
          return data;
        }

      });
    }

    this.items.push(product);
    localStorage.setItem("cart", JSON.stringify(this.items));
   
    console.log('cartItems:',this.items)
  }

  getItems() {
    return this.items;
  }
  removeItem(id:number) {

    if(this.items.length > 0){
      this.items = this.items.filter((data:any)=>{
        if (data.id !== id) {
          return data;
        }
      })
    }
    localStorage.setItem("cart", JSON.stringify(this.items));
  
    return this.items;
  }

  clearCart() {
    this.items = [];
    localStorage.setItem("cart", JSON.stringify(this.items));
   
    return this.items;
  }
}
