import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { CheckoutComponent } from './checkout/checkout.component';
import { RouterModule } from '@angular/router';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { PaymentSuccessComponent } from './payment-success/payment-success.component';



@NgModule({
  declarations: [
    CheckoutComponent,
    PaymentSuccessComponent
  ],
  imports: [
    CommonModule,
    RouterModule,
    FormsModule,
    ReactiveFormsModule
  ],
  exports:[
    CheckoutComponent
  ]
})
export class CheckoutModule { }
