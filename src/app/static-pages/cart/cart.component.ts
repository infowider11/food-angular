import { Component, OnInit } from '@angular/core';
import { MealService } from 'src/app/services/meal.service';
import { OwlOptions } from 'ngx-owl-carousel-o';
import { getDate, ComingSoon } from '../../common_fun'

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css']
})
export class CartComponent implements OnInit {
  myAlreadyItems: any = [];
  cartCount:number = 0;
  meal_ids: any = '';
  mealData: any = [];
  dynamicSlides: any = [];
  preferenceData: any= [];
  ComingSoon: any = ComingSoon;

  customOptions: OwlOptions = {
    loop: true,
    margin: 0,
    items: 1,
    nav: false,
    dots: false,
    dotsEach: false,
    autoplay: true,
  }

  constructor(public mealService: MealService) { }

  ngOnInit(): void {
    this.GetCartItems();
    //this.GetPreferenceById(1);
  }

  GetCartItems(){
    var alreadyItems = localStorage.getItem("cart");
    this.myAlreadyItems = alreadyItems;
    this.myAlreadyItems = JSON.parse(this.myAlreadyItems);

    var result: any = [];
    var ids:any=[];
    if (this.myAlreadyItems && this.myAlreadyItems.length > 0) {
      result = this.myAlreadyItems.filter((data: any) => {
        //console.log(data.id);
      
        ids.push(data.id);
        //return this.meal_id = 
      });
    }
    this.meal_ids = ids.toString();
    console.log('id', this.meal_ids);
    this.MyMealData();
    

  }

  MyMealData() {
    this.mealService.getMealData(this.meal_ids).subscribe((data: any) => {
      //console.log('mealData', data);
      if (data.status == 1) {

        for(let i = 0; i < data.data.length; i++){
          let newData = data.data[i];

          let obj = this.myAlreadyItems.find(function(item:any){
            return item.id === newData.id;

            //console.log('hello',item.id);
          })

          if(obj){
            newData.carddata = obj
          }
          
          
          this.mealData.push(newData);
        }

        console.log('sdf',this.mealData)
      }
    }); 
  } 


  getPerferenceName(preference_id: any=''){

    if(preference_id !== "0") {
     
      /*this.mealService.getPreferencesById(preference_id).subscribe((data: any) => {
        console.log('preferences', data);
        if (data.status == 1) {
          return this.preferenceData = data.data.title;
        }
      }) */
      console.log('id', preference_id);
    }
    //console.log('cat', this.preferenceData) ;
  } 


}
