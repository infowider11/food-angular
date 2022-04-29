import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './auth-user/login/login.component';
import { HomePageComponent } from './home/home-page/home-page.component';
import { AboutUsComponent } from './static-pages/about-us/about-us.component';
import { ContactUsComponent } from './static-pages/contact-us/contact-us.component';
import { LandingPageComponent } from './static-pages/landing-page/landing-page.component';
import { MealDetailComponent } from './static-pages/meal-detail/meal-detail.component';
import { PageNotFoundComponent } from './static-pages/page-not-found/page-not-found.component';
import { PrivacyPolicyComponent } from './static-pages/privacy-policy/privacy-policy.component';
import { SearchComponent } from './static-pages/search/search.component';
import { TermsAndConditionsComponent } from './static-pages/terms-and-conditions/terms-and-conditions.component';

const routes: Routes = [
  { path: '', redirectTo: 'home', pathMatch: 'full'},
  { path: 'home', component: LandingPageComponent },
  { path: 'area-group/:id', component: HomePageComponent },
  { path: 'about-us', component: AboutUsComponent},
  { path: 'contact-us', component: ContactUsComponent},
  { path: 'login', component: LoginComponent},
  { path: 'terms-and-conditions', component: TermsAndConditionsComponent},
  { path: 'privacy-policy', component: PrivacyPolicyComponent},
  { path: 'search', component: SearchComponent},
  { path: 'meal-detail/:id', component: MealDetailComponent},


  { path: '**', pathMatch: 'full', 
        component: PageNotFoundComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes,{scrollPositionRestoration: 'enabled'})],
  exports: [RouterModule]
})
export class AppRoutingModule { }
