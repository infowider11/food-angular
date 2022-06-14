import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashbordComponent } from './dashbord/dashbord.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { SidebarComponent } from './sidebar/sidebar.component';
import { ChangePasswordComponent } from './change-password/change-password.component';
import { MealHistoryComponent } from './meal-history/meal-history.component';
import { MyTransactionsComponent } from './my-transactions/my-transactions.component';
import { MyAddressComponent } from './my-address/my-address.component';



@NgModule({
  declarations: [
    DashbordComponent,
    SidebarComponent,
    ChangePasswordComponent,
    MealHistoryComponent,
    MyTransactionsComponent,
    MyAddressComponent
  ],
  imports: [
    CommonModule,
    RouterModule,
    FormsModule,
    ReactiveFormsModule,
  ]
})
export class UserModule { }
