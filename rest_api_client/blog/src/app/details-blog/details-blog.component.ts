import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Article } from '../model/Article';
import { ServiceService } from '../service/service.service';
@Component({
  selector: 'app-details-blog',
  templateUrl: './details-blog.component.html',
  styleUrls: ['./details-blog.component.scss']
})
export class DetailsBlogComponent implements OnInit {
  blog :Article=new Article;
  all: any[] = [];
  id:Number;
  contenu:string="";
  actif:boolean=true;
  email:string="";
  pass:string="";
  created_at:Date= new Date();
  constructor( private route: ActivatedRoute,private service:ServiceService  ) {
   this.id=parseInt(route.snapshot.paramMap.get('id')||"-1");
    this.service.detailarticle(parseInt(route.snapshot.paramMap.get('id')||"-1")).subscribe(data =>{ 
      this.blog=data;
    });
   }

  ngOnInit(): void {
  }
 
addComment(){
  this.service.addComment(this.id,this.contenu,this.actif,this.email,this.pass,this.created_at).subscribe(data => {
    console.log(data);
  }, err => {
    console.log(err);
  })
}
getAllCo() {
  console.log("hello me");
 this.service.getALLComm().subscribe(data => {
   this.all=data;
   console.log(data);
 }, err => {
   console.log(err);
 });
}

}
