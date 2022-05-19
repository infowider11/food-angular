import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { MealService } from 'src/app/services/meal.service';
import { OwlOptions } from 'ngx-owl-carousel-o';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { CommonServiceService } from 'src/app/services/common-service.service';
import { IDropdownSettings } from 'ng-multiselect-dropdown';
import { getDate, ComingSoon, AlertMessage } from '../../common_fun'
import { CartService } from '../../services/cart.service'


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
  AlertMessage: any = AlertMessage;
  date = new Date();
  timestand = new Date().setDate(new Date().getDate() + 7);
  maxDate = new Date(this.timestand);
  showErrorForDate: boolean = false;
  myHolidayDates = [
    new Date("12/1/2020")
  ];
  myHolidayDays = [
    '1'
  ];

  myHolidayFilter = (d: any): boolean => {
    if (d && this.myHolidayDates.length > 0) {

      let returndata = true;

      const time = d.getTime();
      const day = d.getDay();
      //return !this.myHolidayDates.find(x => x.getTime() == time);

      if (this.myHolidayDates.find(x => x.getTime() == time)) {
        returndata = false;
      }

      if (this.myHolidayDays.find(x => x == day)) {
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
      date: '',
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

  constructor(
    public mealService: MealService,
    private router: Router,
    private actRoute: ActivatedRoute,
    public commonServices: CommonServiceService,
    private cartService: CartService
  ) {
    this.meal_id = this.actRoute.snapshot.params['id'];
    console.log(this.meal_id);
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }

  addMore() {
    this.mealOptions.push({
      date: '',
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


    this.mealService.getMealById(this.meal_id).subscribe((data: any) => {
      console.log('getMealById', data);

      this.showLoader = false;

      if (data.status == 1) {
        this.mealData = data.data;
        this.dynamicSlides = data.data.images
        console.log(this.myHolidayDates);

        if (data.data.disabled_dates) {
          const disabled_dates = data.data.disabled_dates.split(",")

          for (let i = 0; i < disabled_dates.length; i++) {
            this.myHolidayDates.push(new Date(disabled_dates[i]))
          }
        }

        if (data.data.disabled_days) {
          const disabled_days = data.data.disabled_days.split(",")

          for (let i = 0; i < disabled_days.length; i++) {
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

    let checkDate = this.mealOptions.find((item: any) => {
      if (item.date == '') {
        return item
      }
    })

    if (checkDate) {
      console.log('mealOptions', this.mealOptions);
      this.showErrorForDate = true
      return
    }

    var myArr: any = {};
    myArr.id = this.meal_id;
    myArr.remark = this.remark;

    this.showErrorForDate = false

    myArr.item = this.mealData;





    for (let i = 0; i < this.mealOptions.length; i++) {
      let preference = this.mealOptions[i].preference;


      for (let k = 0; k < preference.length; k++) {
        let newPref = this.preferences.filter((item: any) => {
          if (preference[k].id == item.id) {
            return item;
          }
        })
        if (newPref.length > 0) {
          this.mealOptions[i].preference[k] = newPref
        }

      }

    }

    myArr.product = this.mealOptions;




    this.cartService.addToCart(myArr);

    this.router.navigate(['/cart']);
    return;
  }

  OpenModal(id: any) {
    new window.bootstrap.Modal(
      document.getElementById('preference-popup' + id)
    ).show();
  }



}
