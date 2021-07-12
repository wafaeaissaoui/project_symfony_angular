import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { MenuComponent } from './menu/menu.component';
import { BlogComponent} from './blog/blog.component';
import { DetailsBlogComponent } from './details-blog/details-blog.component';

const routes: Routes = [
  { path: 'page', component: MenuComponent  },
  { path: 'blog', component: BlogComponent  },
  { path: 'info/:id', component: DetailsBlogComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
