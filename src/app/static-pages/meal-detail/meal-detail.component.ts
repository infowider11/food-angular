import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { MealService } from 'src/app/services/meal.service';
import { OwlOptions } from 'ngx-owl-carousel-o';

@Component({
  selector: 'app-meal-detail',
  templateUrl: './meal-detail.component.html',
  styleUrls: ['./meal-detail.component.css']
})
export class MealDetailComponent implements OnInit {
  meal_id:any='';
  showLoader:boolean=true;
  mealData:any={};
  dynamicSlides:any = [];
  mealsTypes: any = [];
  reviews:any=[];

  customOptions: OwlOptions = {
    loop: true,
    margin: 0,
    items: 1,
    nav: false,
    dots: false,
    dotsEach: false,
    autoplay: true,
  }

  constructor(public mealService:MealService, private router: Router, private actRoute:ActivatedRoute) {
    this.meal_id = this.actRoute.snapshot.params['id'];
    console.log(this.meal_id);
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }

  getMealByIdfun(){
    if(!this.meal_id){
      this.router.navigate(['/home']); 
      return;
    }

    this.mealService.getMealById(this.meal_id).subscribe((data:any)=>{
      console.log('getMealById',data);

      this.showLoader=false;

      if (data.status == 1) {
        this.mealData = data.data;
        this.dynamicSlides = data.data.images
      } else {
        this.router.navigate(['/home']); 
        return;
      }

    })


  };

  ngOnInit(): void {
    this.getMealByIdfun();

    this.mealService.getMealType().subscribe((data: any) => {
      console.log('mealsTypes',data);

      if (data.status == 1 && data.data.length > 0) {
        this.mealsTypes = data.data;
      }


    })
  }

}
