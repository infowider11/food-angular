import { Component, OnInit } from '@angular/core';
import { CommonServiceService } from 'src/app/services/common-service.service';

@Component({
  selector: 'app-terms-and-conditions',
  templateUrl: './terms-and-conditions.component.html',
  styleUrls: ['./terms-and-conditions.component.css']
})
export class TermsAndConditionsComponent implements OnInit {

  aboutContent:string = '';

  constructor(public commonServices: CommonServiceService) { }

  ngOnInit(): void {
    this.commonServices.getTermsPageContent().subscribe((data:any)=>{
      console.log(data);
      if(data.status==1){
        this.aboutContent = data.data
      }
    })
  }

}
