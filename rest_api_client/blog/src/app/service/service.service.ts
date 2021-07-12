import { Injectable } from '@angular/core';
import { HttpClient,HttpHeaders } from '@angular/common/http';
import { Observable, Subject } from 'rxjs';
import { Article } from '../model/Article';
@Injectable({
  providedIn: 'root'
})
export class ServiceService {
private baseURL = 'http://127.0.0.1:8000/api/';


  constructor(private http:HttpClient) { 
  
  }
  Addblog(titre:String, contenu:String,created_at:Date, image:String):Observable<any>{
     let data= {
        titre : titre,
        contenu : contenu,
        created_at:created_at,
        image : image     
    }
    console.log("data in service" , data)

    return this.http.post(this.baseURL+"ajouter",data);
  }
  getArticle():Observable<any>{
    var art:Article[] = [];
    return this.http.get(this.baseURL+"articles/liste");
  }
  Editblog(newBlog:Article):Observable<any>{
   
   console.log("data in service" , newBlog)

   return this.http.put(this.baseURL+`editer/${newBlog.id}`, newBlog);
 }
DeleteArticle(id:any):Observable<Article>{

  return this.http.delete<Article>(this.baseURL+`supprimer/${id}`);

}
detailarticle(id:any):Observable<any>{
  return this.http.get(this.baseURL+`lire/${id}`) 
}
addComment(id:any, contenu:String, actif:boolean,email:String,pass:String,created_at:Date, ):Observable<any>{
let data={
  contenu:contenu,
  actif:actif,
  email:email,
  pass:pass,
  created_at:created_at

}
  return this.http.post(this.baseURL+`comment/${id}`,data)

}
getALLComm():Observable<any>{
  var art:[] = [];
    return this.http.get(this.baseURL+"comments/liste");
}

}
