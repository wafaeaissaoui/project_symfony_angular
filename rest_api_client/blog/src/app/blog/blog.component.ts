import { Component, OnInit } from '@angular/core';
import { ServiceService } from '../service/service.service';
import {Router} from '@angular/router';
@Component({
  selector: 'app-blog',
  templateUrl: './blog.component.html',
  styleUrls: ['./blog.component.scss']
})
export class BlogComponent implements OnInit {
  all_blogs: any[] = [];
  floating:string='';
  titre:string='';
  contenu:string='';
  created_at:Date;
  image:string='';
  constructor( private service:ServiceService,private router :Router  ) {
    this.getAll(); 
    this.created_at=new Date();
  
   }
 
  ngOnInit(): void {
  }
  getAll() {
     console.log("hello me");
    this.service.getArticle().subscribe(data => {
      this.all_blogs=data;
      console.log(data);
    }, err => {
      console.log(err);
    });
}
save(){
  this.service.Addblog(this.titre,this.contenu,this.created_at,this.image,).subscribe(data => {
    console.log(data);
  }, err => {
    console.log(err);
  })
}
info(id:any,event:Event){
  event.preventDefault();
  this.router.navigate(["info/"+id]);
}
}
