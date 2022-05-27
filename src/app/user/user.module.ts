import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashbordComponent } from './dashbord/dashbord.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { SidebarComponent } from './sidebar/sidebar.component';
import { ChangePasswordComponent } from './change-password/change-password.component';
import { MealHistoryComponent } from './meal-history/meal-history.component';



@NgModule({
  declarations: [
    DashbordComponent,
    SidebarComponent,
    ChangePasswordComponent,
    MealHistoryComponent
  ],
  imports: [
    CommonModule,
    RouterModule,
    FormsModule,
    ReactiveFormsModule,
  ]
})
export class UserModule { }
