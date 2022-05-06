import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { MealService } from 'src/app/services/meal.service';
import { OwlOptions } from 'ngx-owl-carousel-o';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { CommonServiceService } from 'src/app/services/common-service.service';
import { IDropdownSettings  } from 'ng-multiselect-dropdown'
//import { MultipleDatePicker, DateRangeHelper } from '../multiselect';
import { getDate, ComingSoon } from '../../common_fun'
declare var $: any;

@Component({
  selector: 'app-meal-detail',
  templateUrl: './meal-detail.component.html',
  styleUrls: ['./meal-detail.component.css']
})
export class MealDetailComponent implements OnInit {
  meal_id: any = '';
  showLoader: boolean = true;
  mealData: any = {};
  dynamicSlides: any = [];
  mealsTypes: any = [];
  reviews: any = [];
  form!: FormGroup;
  contactFormMsg:string="";
  contactFormLoader:boolean=false;
  preferences:any=[];
  dropdownSettings:IDropdownSettings={};
  today:any=getDate()
  ComingSoon:any=ComingSoon

  mealOptionIn:any={
    date:'',
    meal_type:'',
    preference:'',
    qunatity:1
  }

  mealOptions:any = [this.mealOptionIn]

  

  customOptions: OwlOptions = {
    loop: true,
    margin: 0,
    items: 1,
    nav: false,
    dots: false,
    dotsEach: false,
    autoplay: true,
  }

  constructor(public mealService: MealService, private router: Router, private actRoute: ActivatedRoute,public commonServices:CommonServiceService) {
    this.meal_id = this.actRoute.snapshot.params['id'];
    console.log(this.meal_id);
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }

  addMore(){
    this.mealOptions.push(this.mealOptionIn);
  }
  remoteItem(i:any){
    this.mealOptions.splice(i,1)
  }

  getMealByIdfun() {
    if (!this.meal_id) {
      this.router.navigate(['/home']);
      return;
    }

    console.log(this.mealOptions);

    this.mealService.getMealById(this.meal_id).subscribe((data: any) => {
      console.log('getMealById', data);

      this.showLoader = false;

      if (data.status == 1) {
        this.mealData = data.data;
        this.dynamicSlides = data.data.images
      } else {
        this.router.navigate(['/home']);
        return;
      }

    })


  };


  resetForm(){
    this.form = new FormGroup({
      name: new FormControl('',[Validators.required]),
      email:new FormControl('',[Validators.required,Validators.email]),
      phone:new FormControl('',[Validators.required]),
      delivery_address:new FormControl('',[Validators.required])
    })
    
  }

  ngOnInit(): void {

    this.dropdownSettings = {
      idField: 'id',
      textField: 'title',
      enableCheckAll:false,
      limitSelection:5
    };

    
    
    this.getMealByIdfun();
    this.resetForm();

    this.mealService.getMealType().subscribe((data: any) => {
      console.log('mealsTypes', data);

      if (data.status == 1 && data.data.length > 0) {
        this.mealsTypes = data.data;
      }


    })

    this.mealService.getPreferences().subscribe((data:any)=>{
      console.log('preferences',data);
      if(data.status == 1){
        this.preferences = data.data
      }
    })

   
  }

  deliveryFormSubmit(){

    this.contactFormLoader = true;
    console.log('1',this.form.value);


    this.commonServices.contactForSameDay(this.form.value).subscribe((data:any)=>{
      console.log('contact form',data);
      this.contactFormMsg = data.message;
      this.contactFormLoader = false;
      this.resetForm();
      setTimeout(()=>{
        
        this.contactFormMsg = "";
        //$('#contact-popup').modal("hide")
      },3000)
    })
  }

}
