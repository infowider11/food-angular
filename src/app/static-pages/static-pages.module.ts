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
import { FormsModule } from '@angular/forms'; 
import { CarouselModule } from 'ngx-owl-carousel-o';



@NgModule({
  declarations: [
    ContactUsComponent,
    AboutUsComponent,
    TermsAndConditionsComponent,
    PrivacyPolicyComponent,
    PageNotFoundComponent,
    SearchComponent,
    MealDetailComponent,
    LandingPageComponent
  ],
  imports: [
    CommonModule,
    RouterModule,
    FormsModule,
    CarouselModule
  ],
  exports:[
    ContactUsComponent,
    AboutUsComponent
  ]
})
export class StaticPagesModule { }
