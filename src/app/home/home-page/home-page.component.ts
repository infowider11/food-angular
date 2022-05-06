import { Component, OnInit } from '@angular/core';
import { MealService } from '../../services/meal.service';
import { CommonServiceService } from 'src/app/services/common-service.service';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { OwlOptions } from 'ngx-owl-carousel-o';

declare var $: any;

@Component({
  selector: 'app-home-page',
  templateUrl: './home-page.component.html',
  styleUrls: ['./home-page.component.css']
})
export class HomePageComponent implements OnInit {

  categories: any = [];
  mealsTypes: any = [];
  meals: any = [];
  areas: any = [];
  homePageContent: any = {};
  whyOrderContent: any = {};
  setisfiedCount: number = 0;
  foodDeliveredCount: number = 0;
  experienceCount: number = 0;
  showMealsLoader = true;
  mealsearch: any = {}
  catid = 0;
  mealtype = 0;
  selectedAreaId: any = "";
  area_group: any = '';
  dynamicSlides:any = []


  constructor(public mealService: MealService, public commonService: CommonServiceService, private router: Router, private actRoute: ActivatedRoute) {

    this.area_group = this.actRoute.snapshot.params['id'];
    console.log(this.area_group);
    this.selectedAreaId = this.area_group;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }




  FilterChanged() {
    //console.log("this is cat id",this.catid)
    this.showMealsLoader = true
    this.getMealsFun();
  }

  //console.log(this.area_id);

  OpenLocationWiseMeals(area_id: any) {
    if (!area_id) {
      alert('Select Area');
      return;
    }
    //this.getMealsFun();

    this.router.navigateByUrl('/RefreshComponent', { skipLocationChange: true }).then(() => {
      this.router.navigate(['/area-group/' + area_id]);
    });

    this.router.navigate(['/area-group/' + area_id], {
      /*queryParams:{
        area_group:area_id
      }*/
    });
    this.ngOnInit();

  }

 

  getMealsFun() {

    console.log(this.area_group);

    if (this.catid) {
      this.mealsearch["category"] = this.catid
    }
    if (this.mealtype) {
      this.mealsearch["meal_type"] = this.mealtype
    }

    if (this.area_group) {
      this.mealsearch["area_group"] = this.area_group
    }


    this.mealService.getMeals(this.mealsearch).subscribe((data: any) => {
      console.log(data);
      this.showMealsLoader = false

      if (data.status == 1) {
        this.meals = data.data;
      }


    })
  }

  getHomePageContentFun() {
    this.commonService.getHomePageContent().subscribe((data: any) => {
      console.log(data);
      if (data.status == 1 && data.data.homePage) {
        /*if(data.data.homePage){
          this.homePageContent = data.data.homePage
        }*/

        if (data.data.whyOrder) {
          this.whyOrderContent = data.data.whyOrder
        }

        this.setisfiedCount = data.data.satisfied;
        this.foodDeliveredCount = data.data.foodDelivered;
        this.experienceCount = data.data.experience;
      }
    })
  }


  getAreaServedByIdFun() {
    this.mealService.getAreaServedById(this.area_group).subscribe((data: any) => {
      console.log(data);
      if (data.status == 1 && data.data) {
        this.homePageContent = data.data
        this.dynamicSlides = data.data.images
      }
    })
  }

  customOptions: OwlOptions = {
    loop: true,
    margin: 0,
    items: 1,
    nav: false,
    dots: false,
    dotsEach: false,
    autoplay: true,
  }

  ngOnInit(): void {

    this.getMealsFun();
    this.getHomePageContentFun();
    this.getAreaServedByIdFun();


    this.mealService.getCategory().subscribe((data: any) => {
      console.log(data);

      if (data.status == 1 && data.data.length > 0) {
        this.categories = data.data;
      }


    })

    this.mealService.getMealType().subscribe((data: any) => {
      console.log(data);

      if (data.status == 1 && data.data.length > 0) {
        this.mealsTypes = data.data;
      }


    })



    this.mealService.getAreaServed().subscribe((data: any) => {
      console.log(data);

      if (data.status == 1 && data.data.length > 0) {
        this.areas = data.data;
        //$('#select_area').niceSelect('update');
      }


    })

    $(document).ready(function () {
      //$('#select_area').niceSelect();
    })
  }







}
