import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { MealService } from 'src/app/services/meal.service';
import { OwlOptions } from 'ngx-owl-carousel-o';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { CommonServiceService } from 'src/app/services/common-service.service';
import { IDropdownSettings } from 'ng-multiselect-dropdown';
import { getDate, ComingSoon } from '../../common_fun'


declare var $: any;
declare var window: any;

@Component({
  selector: 'app-meal-detail',
  templateUrl: './meal-detail.component.html',
  styleUrls: ['./meal-detail.component.css']
})
export class MealDetailComponent implements OnInit {

  meal_id: any = '';
  remark: string = "";
  showLoader: boolean = true;
  mealData: any = {};
  dynamicSlides: any = [];
  mealsTypes: any = [];
  reviews: any = [];
  form!: FormGroup;
  myAlreadyItems: any = [];
  formAddCart!: FormGroup;
  contactFormMsg: string = "";
  contactFormLoader: boolean = false;
  preferences: any = [];
  storedItems: any = [];
  retrievedData: string = '';
  dropdownSettings: IDropdownSettings = {};
  today: any = getDate()
  ComingSoon: any = ComingSoon;
  date = new Date();
  timestand = new Date().setDate(new Date().getDate() + 7);
  maxDate = new Date(this.timestand);

  myHolidayDates = [
    new Date("12/1/2020")
  ];
  myHolidayDays = [
    '1'
  ];
  
  myHolidayFilter = (d:any): boolean => {
    if(d && this.myHolidayDates.length > 0){

      let returndata = true;

      const time = d.getTime();
      const day = d.getDay();
      //return !this.myHolidayDates.find(x => x.getTime() == time);

      if(this.myHolidayDates.find(x => x.getTime() == time)){
        returndata = false;
      }

      if(this.myHolidayDays.find(x => x == day)){
        returndata = false;
      }

      return returndata;
    } else {
      return true;
    }
    
  }



  mealOptionIn: any = {
    date: '',
    preference: [{ id: "0" }, { id: "0" }, { id: "0" }, { id: "0" }, { id: "0" }],
    qunatity: 1
  }

  mealOptions: any = [
    {
      date: new Date(),
      preference: [{ id: "0" }, { id: "0" }, { id: "0" }, { id: "0" }, { id: "0" }],
      qunatity: 1
    }
  ]



  customOptions: OwlOptions = {
    loop: true,
    margin: 0,
    items: 1,
    nav: false,
    dots: false,
    dotsEach: false,
    autoplay: true,
  }

  constructor(public mealService: MealService, private router: Router, private actRoute: ActivatedRoute, public commonServices: CommonServiceService) {
    this.meal_id = this.actRoute.snapshot.params['id'];
    console.log(this.meal_id);
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }

  addMore() {
    this.mealOptions.push({
      date: new Date(),
      preference: [{ id: "0" }, { id: "0" }, { id: "0" }, { id: "0" }, { id: "0" }],
      qunatity: 1
    });
  }
  remoteItem(i: any) {
    this.mealOptions.splice(i, 1)
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
        console.log(this.myHolidayDates);

        if(data.data.disabled_dates){
          const  disabled_dates = data.data.disabled_dates.split(",")
      
          for(let i =0; i < disabled_dates.length; i++){
            this.myHolidayDates.push(new Date(disabled_dates[i]))
          }
        }

        if(data.data.disabled_days){
          const  disabled_days = data.data.disabled_days.split(",")
      
          for(let i =0; i < disabled_days.length; i++){
            this.myHolidayDays.push(disabled_days[i])
          }
        }

        this.getMyPreferences();
      } else {
        this.router.navigate(['/home']);
        return;
      }

    })


  };


  resetForm() {
    this.form = new FormGroup({
      name: new FormControl('', [Validators.required]),
      email: new FormControl('', [Validators.required, Validators.email]),
      phone: new FormControl('', [Validators.required]),
      delivery_address: new FormControl('', [Validators.required])
    })

  }


  ngOnInit(): void {



    this.dropdownSettings = {
      idField: 'id',
      textField: 'title',
      enableCheckAll: false,
      limitSelection: 5
    };



    this.getMealByIdfun();
    this.resetForm();

    this.mealService.getMealType().subscribe((data: any) => {
      console.log('mealsTypes', data);

      if (data.status == 1 && data.data.length > 0) {
        this.mealsTypes = data.data;
      }


    })




  }

  getMyPreferences() {
    this.mealService.getPreferences(this.mealData.category.id).subscribe((data: any) => {
      console.log('preferences', data);
      if (data.status == 1) {
        this.preferences = data.data
      }
    })
  }

  deliveryFormSubmit() {

    this.contactFormLoader = true;
    console.log('1', this.form.value);


    this.commonServices.contactForSameDay(this.form.value).subscribe((data: any) => {
      console.log('contact form', data);
      this.contactFormMsg = data.message;
      this.contactFormLoader = false;
      this.resetForm();
      setTimeout(() => {

        this.contactFormMsg = "";
        //$('#contact-popup').modal("hide")
      }, 3000)
    })
  }

  addtoCart() {

    //localStorage.setItem("cart",'[{"id":"6","remark":"sdfsdf","product":[{"date":"2022-05-10","meal_type":"1","preference":[{"id":"1","title":"Jackfruit dry"}],"qunatity":3}]},{"id":"8","remark":"esfsffd ","product":[{"date":"2022-05-11","meal_type":"1","preference":[{"id":"1","title":"Jackfruit dry"},{"id":"2","title":"Matar paneer"}],"qunatity":1},{"date":"2022-05-12","meal_type":"2","preference":[{"id":"2","title":"Matar paneer"}],"qunatity":1}]},{"id":"9","remark":"sfdsfdsf","product":[{"date":"2022-05-11","meal_type":"2","preference":[{"id":"2","title":"Matar paneer"}],"qunatity":1},{"date":"2022-05-13","meal_type":"2","preference":[{"id":"1","title":"Jackfruit dry"}],"qunatity":1}]},{"id":"2","remark":"sdfdsfs","product":[{"date":"2022-05-10T10:44:16.093Z","preference":"","qunatity":2},{"date":"2022-05-11T18:30:00.000Z","preference":"","qunatity":3},{"date":"2022-05-13T18:30:00.000Z","preference":"","qunatity":3}]}]');

    var alreadyItems = localStorage.getItem("cart");
    this.myAlreadyItems = alreadyItems;
    var alreadyItemsArr = JSON.parse(this.myAlreadyItems);

    //console.log('data-length', alreadyItemsArr.length);
    //console.log('data', alreadyItemsArr);
    let result: any = [];
    if (alreadyItemsArr && alreadyItemsArr.length > 0) {
      result = alreadyItemsArr.filter((data: any) => {
        console.log(data.id);
        if (data.id !== this.meal_id) {
          return data;
        }

      });
    }
    var myArr: any = {};
    myArr.id = this.meal_id;
    myArr.remark = this.remark;
    myArr.product = this.mealOptions;
    result.push(myArr);

    localStorage.setItem("cart", JSON.stringify(result));
    console.log('data', localStorage.getItem("cart"));
    this.router.navigate(['/cart']);
    return;
  }

  OpenModal(id: any) {
    new window.bootstrap.Modal(
      document.getElementById('preference-popup' + id)
    ).show();
  }



}
