import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CartService } from 'src/app/services/cart.service';
import { CommonServiceService } from 'src/app/services/common-service.service';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { UserService } from 'src/app/services/user.service';
import { ComingSoon } from 'src/app/common_fun';
import { AuthService } from 'src/app/services/auth.service';


@Component({
  selector: 'app-checkout',
  templateUrl: './checkout.component.html',
  styleUrls: ['./checkout.component.css']
})
export class CheckoutComponent implements OnInit {

  items: any = [];
  totalPrice: any = 0;
  tax:any = 0;
  tax_price:any = 0;
  form!: FormGroup;
  delivery_fee:any=0;
  grandTotal:any=0;
  is_pickupPoint:number=1;
  pickup_address:any=[];
  paymentHandler:any = null;
  stripe_pk:string='';
  ComingSoon: any = ComingSoon;
  checkout_user_info:any=this.AuthService.userdata;
  is_new_user:boolean= (this.AuthService.is_user_logged_in) ? true : false;
  is_logged_in:boolean = this.AuthService.is_user_logged_in;
  is_loading:boolean= false;

  login_error_message:string = '';
  same_password_error:string = '';
  signup_password_error:string = '';

  step1BtnClicked:boolean=false;
  step2BtnClicked:boolean=false;
  step3BtnClicked:boolean=false;
  step4BtnClicked:boolean=false;
  step5BtnClicked:boolean=false;
  step6BtnClicked:boolean=false;

  step1:boolean=true;
  step2:boolean=false;
  step3:boolean=false;
  step4:boolean=false;
  step5:boolean=false;
  step6:boolean=false;


  constructor(
    public cartService: CartService,
    private router: Router,
    private commonService:CommonServiceService,
    private userService:UserService,
    public AuthService:AuthService
  ) { }

  ngOnInit(): void {

    if(this.is_logged_in){
      this.step1=false;
      this.step2= false;
      this.step3=true
    }

    /*this.userService.CheckEmail('anil.webwiders@gmail.com').subscribe((data:any)=>{
      console.log(data)
    })*/
    this.myFormCondition();

    if (this.cartService.items.length == 0) {
      this.router.navigate(['/home']);
      return
    }
    this.commonService.getSetting().subscribe((data:any)=>{
      if(data.status==1){
        this.tax = parseFloat(data.data.tax);
        this.delivery_fee = parseFloat(data.data.delivery_fee);
        this.stripe_pk = data.data.stripe_pk;

        if(this.totalPrice){
          let taxes = this.totalPrice *  this.tax / 100;
          
          this.tax_price = taxes.toFixed(2);
        }

        this.grandTotal = parseFloat(this.tax_price) + parseFloat(this.totalPrice) + parseFloat(this.delivery_fee);
        this.grandTotal = this.grandTotal.toFixed(2);

        //this.invokeStripe();
      
        
      }
    })
    this.GetCartItems();

    this.commonService.get_pickup_address().subscribe((data:any)=>{
      if(data.status==1){
        this.pickup_address = data.data
      }
    })

    
  }


  myFormCondition(){

    this.form = new FormGroup({
      email: new FormControl('', [Validators.required, Validators.email]),
      name: new FormControl('',[Validators.required]),
      password: new FormControl('',[Validators.required]),
      set_password: new FormControl('',[Validators.required]),
      confirm_password: new FormControl('',[Validators.required]),
      pickup_location: new FormControl('',[Validators.required]),
      delivery_name: new FormControl('',[Validators.required]),
      delivery_phone: new FormControl('',[Validators.required, Validators.pattern('[- +()0-9]+')]),
      delivery_email: new FormControl('',[Validators.required, Validators.email]),
      delivery_address: new FormControl('',[Validators.required]),
      delivery_remark: new FormControl(''),
    })

  }

  

  checkEmail(){

    console.log(this.form.controls['email'].invalid)

    if(this.form.controls['email'].invalid){
      this.step2 = false;
      this.step3 = false;
      this.step4 = false;
      this.step5 = false;
      this.step6 = false;
      return
    }

    this.is_loading = true
    
    this.userService.CheckEmail(this.form.value.email).subscribe((data:any)=>{

      this.is_loading = false
 
      if(data.status==1){
        this.checkout_user_info = data.data
        this.is_new_user=false;

        
      } else {
        this.is_new_user=true;
      }

      this.step2 = true;
      
    })
  }

  attemptLogin(){

    console.log(this.form.controls['email'].invalid)

    if(this.form.controls['email'].invalid || this.form.controls['password'].invalid){
      this.is_new_user=false;
      this.step3 = false;
      this.step4 = false;
      this.step5 = false;
      this.step6 = false;
      return
    }

    let loginCre = {
      email : this.form.value.email,
      password: this.form.value.password
    }

    this.is_loading = true
  
    this.userService.attemptLogin(loginCre).subscribe((data:any)=>{
      console.log('login data',data);
      this.is_loading = false
    
      if(data.status==1){
        this.checkout_user_info = data.data
        this.is_logged_in=true;
        

        this.AuthService.authorization(data.data)
        this.login_error_message='';
      } else {
        this.login_error_message=data.message;
      }

      //this.step3 = true;
      
    })
  }

  showStep3(){

    if(this.is_new_user == true &&  (this.form.controls['set_password'].invalid || this.form.controls['confirm_password'].invalid || this.form.controls['name'].invalid)){
      this.step3 = false
      this.step4 = false;
      this.step5 = false;
      this.step6 = false;
      return
    } else if(this.form.value.set_password != this.form.value.confirm_password) {
      this.same_password_error = "Confirm password not matched with new Password field"
      this.step3 = false;
      this.step4 = false;
      this.step5 = false;
      this.step6 = false;
      return
    } else {

      this.same_password_error = ''

      let SignupCre = {
        email : this.form.value.email,
        password: this.form.value.set_password,
        name: this.form.value.name
      }

      this.is_loading = true
      this.userService.signup(SignupCre).subscribe((data:any)=>{
        console.log('login data',data);

        this.is_loading = false
      
        if(data.status==1){
          this.checkout_user_info = data.data
          this.is_logged_in=true;
  
          this.AuthService.authorization(data.data)
          this.signup_password_error='';
        } else {
          this.signup_password_error=data.message;
        }
  
        this.step3 = true
        
      })

      
    }

  }

  
  showStep4(){

    if(this.form.controls['pickup_location'].invalid){
      console.log('step for error ',this.form.controls['pickup_location'].invalid,this.form.value.pickup_location)
      this.step4 = false;
      this.step5 = false;
      this.step6 = false;
      return
    } else {
      this.step4 = true
    }

    

  }

  showStep5(){

    if(this.form.controls['delivery_name'].invalid || this.form.controls['delivery_email'].invalid || this.form.controls['delivery_email'].invalid || this.form.controls['delivery_phone'].invalid || this.form.controls['delivery_address'].invalid){
 
      this.step5 = false;
      this.step6 = false;
      return
    } else {
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


  /*initializePayment(amount: any) {
    //let amount = newAmoutn.toFixed(2);
    const paymentHandler = (<any>window).StripeCheckout.configure({
      key: this.stripe_pk,
      locale: 'auto',
      token: function (stripeToken: any) {
        console.log({stripeToken})
        alert('Stripe token generated!');
      }
    });
  
    paymentHandler.open({
      name: 'Dummy',
      description: 'Testing',
      amount: amount * 100
    });
  }


  invokeStripe() {
    if(!window.document.getElementById('stripe-script')) {
      const script = window.document.createElement("script");
      script.id = "stripe-script";
      script.type = "text/javascript";
      script.src = "https://checkout.stripe.com/checkout.js";
      script.onload = () => {
        this.paymentHandler = (<any>window).StripeCheckout.configure({
          key: this.stripe_pk,
          locale: 'auto',
          token: function (stripeToken: any) {
            console.log(stripeToken)
            alert('Payment has been successfull!');
          }
        });
      }
      window.document.body.appendChild(script);
    }
  }*/

}
