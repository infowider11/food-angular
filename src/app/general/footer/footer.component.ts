import { Component, OnInit } from '@angular/core';
import { CommonServiceService } from 'src/app/services/common-service.service';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.css']
})
export class FooterComponent implements OnInit {

  footerData:any={}
  footerContact:any={}

  constructor(public commonService:CommonServiceService) { }

  ngOnInit(): void {
    this.commonService.getFooterContent().subscribe((data:any)=>{
      if(data.status==1){
        this.footerData=data.data.footerDesc
        this.footerContact=data.data.contact
      }
    })
  }

}
