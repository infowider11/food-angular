import { Component, OnInit } from '@angular/core';
import { CommonServiceService } from 'src/app/services/common-service.service';
import { MealService } from '../../services/meal.service';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';

declare var $: any;

@Component({
  selector: 'app-landing-page',
  templateUrl: './landing-page.component.html',
  styleUrls: ['./landing-page.component.css']
})
export class LandingPageComponent implements OnInit {

  areas: any = [];
  homePageContent:any={};
  area_group:any='';
  selectedAreaId:any="";

  constructor(public mealService: MealService, public commonService: CommonServiceService,private router: Router,private actRoute:ActivatedRoute) {
    this.area_group = this.actRoute.snapshot.params['id'];
  }

  OpenLocationWiseMeals(area_id:any){
    if(!area_id){
      alert('Select Area');
      return;
    }
    //this.getMealsFun();

    this.router.navigate(['/area-group/'+area_id],{
      /*queryParams:{
        area_group:area_id
      }*/
    }); 
    
  }

  getHomePageContentFun(){
    this.commonService.getHomePageContent().subscribe((data:any)=>{
      console.log(data);
      if(data.status==1 && data.data.homePage){
        if(data.data.homePage){
          this.homePageContent = data.data.homePage
        }

      }
    })
  }


  ngOnInit(): void {
    this.getHomePageContentFun();

    this.mealService.getAreaServed().subscribe((data: any) => {
      console.log(data);

      if (data.status == 1 && data.data.length > 0) {
        this.areas = data.data;
        //$('#select_area').niceSelect('update');
      }


    })
  }

}
