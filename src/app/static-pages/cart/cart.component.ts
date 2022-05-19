import { Component, OnInit } from '@angular/core';
import { MealService } from 'src/app/services/meal.service';
import { OwlOptions } from 'ngx-owl-carousel-o';
import { ComingSoon } from '../../common_fun'
import { CartService } from '../../services/cart.service'

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css']
})
export class CartComponent implements OnInit {

  myAlreadyItems: any = [];
  cartCount: number = 0;
  meal_ids: any = '';
  mealData: any = [];
  dynamicSlides: any = [];
  preferenceData: any = [];
  ComingSoon: any = ComingSoon;
  totalPrice: number = 0;

  customOptions: OwlOptions = {
    loop: true,
    margin: 0,
    items: 1,
    nav: false,
    dots: false,
    dotsEach: false,
    autoplay: true,
  }

  constructor(
    public mealService: MealService,
    private cartService: CartService
  ) {

  }

  ngOnInit(): void {

    //this.getMyPreferences();
    this.GetCartItems();
    //this.GetPreferenceById(1);
  }

  GetCartItems() {

    this.myAlreadyItems = this.cartService.getItems();

    let newVar = this.myAlreadyItems;
    if (newVar.length > 0) {
      for (let i = 0; i < newVar.length; i++) {

        if (newVar[i].product.length) {
          let totalQantity = newVar[i].product.map((item: any, index: number) => {
            return item.qunatity;
          }).reduce((prev: any, curr: any) => prev + curr, 0);
          newVar[i].totalQantity = totalQantity;
          this.totalPrice += (totalQantity * newVar[i].item.price);
        } else {
          newVar[i].totalQantity = 0;
          this.totalPrice += (0 * newVar[i].item.price);
        }





      }
    }

    this.mealData = this.myAlreadyItems
    console.log('mealData', this.mealData)

  }

  removeFromCart(remove_meal_id: number) {
    this.cartService.removeItem(remove_meal_id);
    this.GetCartItems();

  }




  getMyPreferences() {
    this.mealService.getPreferences().subscribe((data: any) => {

      if (data.status == 1) {
        this.preferenceData = data.data
      }
      console.log('preferences', this.preferenceData);
    })
  }


}
