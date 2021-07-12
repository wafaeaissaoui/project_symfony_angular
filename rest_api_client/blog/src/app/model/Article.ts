import {Realisateur} from './Realisateur';
import {Commentaire} from './Commentaire';
export class Article{

    id:number;
    titre:string;
    contenu:string;
    created_at:Date;
    image:string;
    realisateur:Realisateur[];
    commentaire:Commentaire[];
    constructor(){
        this.id = -1;
        this.titre="";
        this.contenu ="";
        this.created_at=new Date();
        this.image ="";
        this.realisateur =[];
        this. commentaire =[];
       
    }
}