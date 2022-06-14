import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ForgotComponent } from './auth-user/forgot/forgot.component';
import { LoginComponent } from './auth-user/login/login.component';
import { ResetPasswordComponent } from './auth-user/reset-password/reset-password.component';
import { SignupComponent } from './auth-user/signup/signup.component';
import { CheckoutComponent } from './checkout/checkout/checkout.component';
import { HomePageComponent } from './home/home-page/home-page.component';
import { AboutUsComponent } from './static-pages/about-us/about-us.component';
import { CartComponent } from './static-pages/cart/cart.component';
import { ContactUsComponent } from './static-pages/contact-us/contact-us.component';
import { LandingPageComponent } from './static-pages/landing-page/landing-page.component';
import { MealDetailComponent } from './static-pages/meal-detail/meal-detail.component';
import { PageNotFoundComponent } from './static-pages/page-not-found/page-not-found.component';
import { PrivacyPolicyComponent } from './static-pages/privacy-policy/privacy-policy.component';
import { SearchComponent } from './static-pages/search/search.component';
import { TermsAndConditionsComponent } from './static-pages/terms-and-conditions/terms-and-conditions.component';
import { ChangePasswordComponent } from './user/change-password/change-password.component';
import { DashbordComponent } from './user/dashbord/dashbord.component';
import { MealHistoryComponent } from './user/meal-history/meal-history.component';
import { MyAddressComponent } from './user/my-address/my-address.component';
import { MyTransactionsComponent } from './user/my-transactions/my-transactions.component';

const routes: Routes = [
  { path: '', redirectTo: 'home', pathMatch: 'full' },
  { path: 'home', component: LandingPageComponent },
  { path: 'area-group/:id', component: HomePageComponent },
  { path: 'about-us', component: AboutUsComponent },
  { path: 'contact-us', component: ContactUsComponent },
  { path: 'login', component: LoginComponent },
  { path: 'signup', component: SignupComponent },
  { path: 'terms-and-conditions', component: TermsAndConditionsComponent },
  { path: 'privacy-policy', component: PrivacyPolicyComponent },
  { path: 'search', component: SearchComponent },
  { path: 'meal-detail/:id', component: MealDetailComponent },
  { path: 'cart', component: CartComponent },
  { path: 'checkout', component: CheckoutComponent },
  { path: 'dashboard', component:DashbordComponent},
  { path: 'change-password', component:ChangePasswordComponent},
  { path: 'forgot-password', component:ForgotComponent},
  { path: 'meal-history', component:MealHistoryComponent},
  { path: 'my-transactions', component:MyTransactionsComponent},
  { path: 'my-address', component:MyAddressComponent},
  { path: 'reset-password', component:ResetPasswordComponent},

  {
    path: '**', pathMatch: 'full',
    component: PageNotFoundComponent
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, { scrollPositionRestoration: 'enabled' })],
  exports: [RouterModule]
})
export class AppRoutingModule { }
