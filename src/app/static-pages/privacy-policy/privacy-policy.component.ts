import { Component, OnInit } from '@angular/core';
import { CommonServiceService } from 'src/app/services/common-service.service';

@Component({
  selector: 'app-privacy-policy',
  templateUrl: './privacy-policy.component.html',
  styleUrls: ['./privacy-policy.component.css']
})
export class PrivacyPolicyComponent implements OnInit {

  aboutContent:string = '';

  constructor(public commonServices: CommonServiceService) { }

  ngOnInit(): void {
    this.commonServices.getPrivacyPageContent().subscribe((data:any)=>{
      console.log(data);
      if(data.status==1){
        this.aboutContent = data.data
      }
    })
  }

}
