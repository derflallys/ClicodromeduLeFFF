import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { SearchComponent } from './search/search.component';
import { UploadLefffComponent } from './admin/upload-lefff/upload-lefff.component';
import { AdminHomeComponent } from './admin/admin-home/admin-home.component';
import {RouterModule, Routes} from '@angular/router';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import {HomeComponent} from './home/home.component';
import {HttpClientModule} from '@angular/common/http';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import { ListWordComponent } from './list-word/list-word.component';
import {AddWordComponent} from './add-word/add-word.component';
import { ModifyWordComponent } from './modify-word/modify-word.component';
import { ConsultationComponent } from './consultation/consultation.component';

const appRoutes: Routes = [
  { path: 'admin', component: AdminHomeComponent },
  { path: 'home', component: HomeComponent },
  { path: 'list-word/:word', component: ListWordComponent },
  { path: 'modify-word', component: ModifyWordComponent },
  { path: 'consultation', component: ConsultationComponent },
  { path: 'add-word', component: AddWordComponent  },
  { path: '',
    redirectTo: '/home',
    pathMatch: 'full',
  },
  { path: '**', component: PageNotFoundComponent }
];

@NgModule({
  declarations: [
    AppComponent,
    SearchComponent,
    UploadLefffComponent,
    AdminHomeComponent,
    HomeComponent,
    PageNotFoundComponent,
    ListWordComponent,
    ModifyWordComponent,
    ConsultationComponent,
    AddWordComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    ReactiveFormsModule,
    FormsModule,
    RouterModule.forRoot(
      appRoutes,
      { enableTracing: true } // <-- debugging purposes only
    )
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
