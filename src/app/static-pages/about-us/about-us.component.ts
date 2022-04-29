import { Component, OnInit } from '@angular/core';
import { CommonServiceService } from 'src/app/services/common-service.service';
@Component({
  selector: 'app-about-us',
  templateUrl: './about-us.component.html',
  styleUrls: ['./about-us.component.css']
})

export class AboutUsComponent implements OnInit {

  aboutContent:string = '';

  constructor(public commonServices: CommonServiceService) { }

  ngOnInit(): void {

      this.commonServices.getAboutPageContent().subscribe((data:any)=>{
        console.log(data);
        if(data.status==1){
          this.aboutContent = data.data
        }
      })

  }

}
