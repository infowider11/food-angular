import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HomePageComponent } from './home-page/home-page.component';
import { RouterModule } from '@angular/router';
import { CarouselModule } from 'ngx-owl-carousel-o';


import { FormsModule } from '@angular/forms'; 


@NgModule({
  declarations: [
    HomePageComponent
  ],
  imports: [
    CommonModule,
    FormsModule,
    RouterModule,
    CarouselModule
  ],
  exports:[
    HomePageComponent,
    
  ]
})
export class HomeModule { }
