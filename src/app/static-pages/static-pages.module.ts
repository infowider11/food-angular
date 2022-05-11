import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ContactUsComponent } from './contact-us/contact-us.component';
import { AboutUsComponent } from './about-us/about-us.component';
import { RouterModule } from '@angular/router';
import { TermsAndConditionsComponent } from './terms-and-conditions/terms-and-conditions.component';
import { PrivacyPolicyComponent } from './privacy-policy/privacy-policy.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { SearchComponent } from './search/search.component';
import { MealDetailComponent } from './meal-detail/meal-detail.component';
import { LandingPageComponent } from './landing-page/landing-page.component';
import { FormsModule,ReactiveFormsModule } from '@angular/forms'; 
import { CarouselModule } from 'ngx-owl-carousel-o';
import { NgMultiSelectDropDownModule } from 'ng-multiselect-dropdown';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatNativeDateModule } from '@angular/material/core';
import { CartComponent } from './cart/cart.component';
import { MatInputModule } from '@angular/material/input';
import { MatFormFieldModule } from '@angular/material/form-field';


@NgModule({
  declarations: [
    ContactUsComponent,
    AboutUsComponent,
    TermsAndConditionsComponent,
    PrivacyPolicyComponent,
    PageNotFoundComponent,
    SearchComponent,
    MealDetailComponent,
    LandingPageComponent,
    CartComponent
  ],
  imports: [
    CommonModule,
    RouterModule,
    FormsModule,
    CarouselModule,
    ReactiveFormsModule,
    NgMultiSelectDropDownModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatInputModule,
    MatFormFieldModule
  ],
  exports:[
    ContactUsComponent,
    AboutUsComponent
  ]
})
export class StaticPagesModule { }
