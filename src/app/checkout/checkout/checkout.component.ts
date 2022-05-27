import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CartService } from 'src/app/services/cart.service';
import { CommonServiceService } from 'src/app/services/common-service.service';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { UserService } from 'src/app/services/user.service';
import { ComingSoon } from 'src/app/common_fun';
import { AuthService } from 'src/app/services/auth.service';

declare var Stripe: any;
@Component({
  selector: 'app-checkout',
  templateUrl: './checkout.component.html',
  styleUrls: ['./checkout.component.css']
})
export class CheckoutComponent implements OnInit {

  items: any = [];
  totalPrice: any = 0;
  tax: any = 0;
  tax_price: any = 0;
  form!: FormGroup;
  delivery_fee: any = 0;
  grandTotal: any = 0;
  is_pickupPoint: number = 1;
  pickup_address: any = [];
  paymentHandler: any = null;
  stripe_pk: string = '';
  ComingSoon: any = ComingSoon;
  checkout_user_info: any = this.AuthService.userdata;
  is_new_user: boolean = (this.AuthService.is_user_logged_in) ? true : false;
  is_logged_in: boolean = this.AuthService.is_user_logged_in;
  is_loading: boolean = false;
  is_new_address:string='1'

  login_error_message: string = '';
  same_password_error: string = '';
  signup_password_error: string = '';

  step1BtnClicked: boolean = false;
  step2BtnClicked: boolean = false;
  step3BtnClicked: boolean = false;
  step4BtnClicked: boolean = false;
  step5BtnClicked: boolean = false;
  step6BtnClicked: boolean = false;

  step1: boolean = true;
  step2: boolean = false;
  step3: boolean = false;
  step4: boolean = false;
  step5: boolean = false;
  step6: boolean = false;

  paymentIntentData: any = false;
  makePaymentBtnStatus: any = false;
  stripeCardError: any = '';
  stripe: any = '';
  stripeCard: any = ''
  is_stripeLoading: boolean = false;




  constructor(
    public cartService: CartService,
    private router: Router,
    private commonService: CommonServiceService,
    private userService: UserService,
    public AuthService: AuthService
  ) { }

  ngOnInit(): void {

    if (this.is_logged_in) {
      this.step1 = false;
      this.step2 = false;
      this.step3 = true
    }

    /*this.userService.CheckEmail('anil.webwiders@gmail.com').subscribe((data:any)=>{
      console.log(data)
    })*/
    this.myFormCondition();

    if (this.cartService.items.length == 0) {
      this.router.navigate(['/home']);
      return
    }
    this.commonService.getSetting().subscribe((data: any) => {
      if (data.status == 1) {
        this.tax = parseFloat(data.data.tax);
        this.delivery_fee = parseFloat(data.data.delivery_fee);
        this.stripe_pk = data.data.stripe_pk;

        if (this.totalPrice) {
          let taxes = this.totalPrice * this.tax / 100;

          this.tax_price = taxes.toFixed(2);
        }

        this.grandTotal = parseFloat(this.tax_price) + parseFloat(this.totalPrice) + parseFloat(this.delivery_fee);
        this.grandTotal = this.grandTotal.toFixed(2);

        //this.invokeStripe();


      }
    })
    this.GetCartItems();

    this.commonService.get_pickup_address().subscribe((data: any) => {
      if (data.status == 1) {
        this.pickup_address = data.data
      }
    })


  }


  myFormCondition() {

    this.form = new FormGroup({
      email: new FormControl('', [Validators.required, Validators.email]),
      name: new FormControl('', [Validators.required]),
      password: new FormControl('', [Validators.required]),
      set_password: new FormControl('', [Validators.required]),
      confirm_password: new FormControl('', [Validators.required]),
      pickup_location: new FormControl('', [Validators.required]),
      delivery_name: new FormControl('test', [Validators.required]),
      delivery_phone: new FormControl('234234', [Validators.required, Validators.pattern('[- +()0-9]+')]),
      delivery_email: new FormControl('test@gmail.com', [Validators.required, Validators.email]),
      delivery_address: new FormControl('test', [Validators.required]),
      delivery_remark: new FormControl(''),
    })

  }



  checkEmail() {

    console.log(this.form.controls['email'].invalid)

    if (this.form.controls['email'].invalid) {
      this.step2 = false;
      this.step3 = false;
      this.step4 = false;
      this.step5 = false;
      this.step6 = false;
      return
    }

    this.is_loading = true

    this.userService.CheckEmail(this.form.value.email).subscribe((data: any) => {

      this.is_loading = false

      if (data.status == 1) {
        this.checkout_user_info = data.data
        this.is_new_user = false;


      } else {
        this.is_new_user = true;
      }

      this.step2 = true;

    })
  }

  attemptLogin() {

    console.log(this.form.controls['email'].invalid)

    if (this.form.controls['email'].invalid || this.form.controls['password'].invalid) {
      this.is_new_user = false;
      this.step3 = false;
      this.step4 = false;
      this.step5 = false;
      this.step6 = false;
      return
    }

    let loginCre = {
      email: this.form.value.email,
      password: this.form.value.password
    }

    this.is_loading = true

    this.userService.attemptLogin(loginCre).subscribe((data: any) => {
      console.log('login data', data);
      this.is_loading = false

      if (data.status == 1) {
        this.checkout_user_info = data.data
        this.is_logged_in = true;
        this.step3 = true;

        this.AuthService.authorization(data.data)
        this.login_error_message = '';
      } else {
        this.login_error_message = data.message;
      }



    })
  }

  showStep3() {

    if (this.is_new_user == true && (this.form.controls['set_password'].invalid || this.form.controls['confirm_password'].invalid || this.form.controls['name'].invalid)) {
      this.step3 = false
      this.step4 = false;
      this.step5 = false;
      this.step6 = false;
      return
    } else if (this.form.value.set_password != this.form.value.confirm_password) {
      this.same_password_error = "Confirm password not matched with new Password field"
      this.step3 = false;
      this.step4 = false;
      this.step5 = false;
      this.step6 = false;
      return
    } else {

      this.same_password_error = ''

      let SignupCre = {
        email: this.form.value.email,
        password: this.form.value.set_password,
        name: this.form.value.name
      }

      this.is_loading = true
      this.userService.signup(SignupCre).subscribe((data: any) => {
        console.log('login data', data);

        this.is_loading = false

        if (data.status == 1) {
          this.checkout_user_info = data.data
          this.is_logged_in = true;

          this.AuthService.authorization(data.data)
          this.signup_password_error = '';
        } else {
          this.signup_password_error = data.message;
        }

        this.step3 = true

      })


    }

  }


  showStep4() {

    if (this.form.controls['pickup_location'].invalid) {
      console.log('step for error ', this.form.controls['pickup_location'].invalid, this.form.value.pickup_location)
      this.step4 = false;
      this.step5 = false;
      this.step6 = false;
      return
    } else {
      this.step4 = true
    }



  }

  showStep5() {

    if (this.form.controls['delivery_name'].invalid || this.form.controls['delivery_email'].invalid || this.form.controls['delivery_email'].invalid || this.form.controls['delivery_phone'].invalid || this.form.controls['delivery_address'].invalid) {

      this.step5 = false;
      this.step6 = false;


      return
    } else {



      this.mountStrpeCard();


      this.step5 = true
    }



  }



  GetCartItems() {

    let newVar = this.cartService.getItems();

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



    this.items = newVar
    console.log('items', this.items)

  }


  mountStrpeCard() {


    this.stripe = Stripe(this.stripe_pk);

    let formData = {
      email: this.AuthService.userdata.email,
      amount: this.grandTotal
    }

    if (!this.paymentIntentData) {

      this.userService.CreatePaymentIntent(formData).subscribe((data: any) => {
        console.log('CreatePaymentIntent', data)
        if (data.status == 1) {



          this.paymentIntentData = {
            clientSecret: data.clientSecret,
            customerID: data.customerID,
          }

          var elements = this.stripe.elements();
          var style = {
            base: {
              color: "#32325d",
              fontFamily: 'Arial, sans-serif',
              fontSmoothing: "antialiased",
              fontSize: "16px",
              "::placeholder": {
                color: "#32325d"
              }
            },
            invalid: {
              fontFamily: 'Arial, sans-serif',
              color: "#fa755a",
              iconColor: "#fa755a"
            }
          };

          this.stripeCard = elements.create("card", { style: style });
          // Stripe injects an iframe into the DOM
          this.stripeCard.mount("#card-element");
          this.stripeCard.on("change", (event: any) => {
            // Disable the Pay button if there are no card details in the Element
            //$("#latest-stipe-submit").prop('disabled',false);

            //$("#latest-stripe-card-error").html(event.error ? event.error.message : "");

            if (event.error) {
              this.makePaymentBtnStatus = false;
              this.stripeCardError = event.error.message

            } else {
              this.makePaymentBtnStatus = true
            }



          });

          //var form = document.getElementById("latest-stipe-from");

          console.log('card mounted successfully');

          // Complete payment when the submit button is clicked
          //payWithCard(actual_amt,stripe, card, data.clientSecret, data.customerID,type,onSuccess,onError,onCancel);

        } else {
          alert(data.message)
        }

      });

    }


  }

  payWithCard() {



    console.log(this.paymentIntentData)

    this.is_stripeLoading = true;

    this.stripe.confirmCardPayment(this.paymentIntentData.clientSecret, {
      payment_method: {
        card: this.stripeCard
      },
    }).then((result: any) => {
      this.is_stripeLoading = false
      if (result.error) {
        // Show error to your customer
        this.makePaymentBtnStatus = false;
        this.stripeCardError = result.error.message
      } else {
        this.makePaymentBtnStatus = false;
        this.stripeCardError = ''
        // The payment succeeded!
        console.log('paymentSuccess', result)
        //orderComplete(actual_amt,result,customerID,type,onSuccess,onError,onCancel);

        

        this.form.value.payment_id = result.paymentIntent.id;
        this.form.value.payment_method = result.paymentIntent.payment_method;
        this.form.value.customer_id = this.paymentIntentData.customerID;
        this.form.value.customer_secret = this.paymentIntentData.clientSecret;
        this.form.value.grandTotal = this.grandTotal;
        //this.form.value.totalQantity = this.to;
        this.form.value.totalPrice = this.totalPrice;
        this.form.value.tax_price = this.tax_price;
        this.form.value.delivery_fee = this.delivery_fee;

        let n = new FormData();

        n.append('user_id', this.AuthService.userdata.id)
        n.append('payment_id', result.paymentIntent.id)
        n.append('stripe_customer_id', this.paymentIntentData.customerID)
        n.append('grand_total', this.grandTotal)
        n.append('sub_total', this.totalPrice)
        n.append('tax_price', this.tax_price)
        n.append('delivery_fee', this.delivery_fee)
        n.append('delivery_address', this.form.value.delivery_address)
        n.append('delivery_email', this.form.value.delivery_email)
        n.append('delivery_name', this.form.value.delivery_name)
        n.append('delivery_phone', this.form.value.delivery_phone)
        n.append('delivery_remark', this.form.value.delivery_remark)
        n.append('pickup_location', this.form.value.pickup_location)
        n.append('is_new_address', this.is_new_address)


        for(let i = 0; i<this.items.length; i++){

          let new_items2:any = {};

          new_items2.item_id = this.items[i].id

          n.append(`items[${i}][meal_id]`, this.items[i].id);
          n.append(`items[${i}][remark]`, this.items[i].remark);
          n.append(`items[${i}][totalQantity]`, this.items[i].totalQantity);
          n.append(`items[${i}][price]`, this.items[i].totalQantity);

         
          let product_D = this.items[i].product

          for(let l = 0; l<product_D.length; l++){

            n.append(`items[${i}][products][${l}][date]`, product_D[l].date);
            n.append(`items[${i}][products][${l}][quantity]`, product_D[l].qunatity);

         
            let nk:number = 0;

            for(let k = 0; k<product_D.length; k++){
              if(Array.isArray(product_D[l].preference[k]) && product_D[l].preference[k].length > 0){
                

                n.append(`items[${i}][products][${l}][preference][${nk}]`, product_D[l].preference[k][0].id);
                nk++;

              }
            }
          }
        }

        this.userService.MakeOrder(n).subscribe((data: any) => {
          if (data.status == 1) {

            alert(data.message);

            //this.cartService.clearCart();
            this.router.navigate(['/meal-history']);
          } else {
            alert(data.message)
          }
        })

      }
    });

  }


}
