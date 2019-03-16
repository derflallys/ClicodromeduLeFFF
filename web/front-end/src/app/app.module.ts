import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppComponent} from './app.component';
import {SearchComponent} from './components/word/search/search.component';
import {UploadLefffComponent} from './components/admin/upload-lefff/upload-lefff.component';
import {AdminHomeComponent} from './components/admin/admin-home/admin-home.component';
import {RouterModule, Routes} from '@angular/router';
import {PageNotFoundComponent} from './components/page-not-found/page-not-found.component';
import {HomeComponent} from './components/home/home.component';
import {HttpClientModule} from '@angular/common/http';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';

import {AddWordComponent} from './components/word/add/add-word.component';
import {ModifyWordComponent} from './components/word/add/modify/modify-word.component';
import {ConsultationComponent} from './components/word/details/consultation.component';
import {ListWordComponent} from './components/word/list/list-word.component';
import { CombinaisonComponent } from './components/admin/combinaison/combinaison.component';

import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {
  MatToolbarModule,
  MatIconModule,
  MatSidenavModule,
  MatButtonModule,
  MatTooltipModule,
  MatTableModule,
  MatProgressSpinnerModule,
  MatFormFieldModule, MatOptionModule, MatSelectModule, MatInputModule
} from '@angular/material';
import { AddRuleComponent } from './components/admin/rule/add/add-rule/add-rule.component';




const appRoutes: Routes = [
  { path: 'admin', component: AdminHomeComponent },
  { path: 'home', component: HomeComponent },
  { path: 'list/:word', component: ListWordComponent },
  { path: 'modify/:id', component: ModifyWordComponent },
  { path: 'show/:id', component: ConsultationComponent },
  { path: 'add', component: AddWordComponent  },
  { path: 'addrule', component: AddRuleComponent  },
  { path: '',
    redirectTo: '/home',
    pathMatch: 'full',
  },
<<<<<<< HEAD
  { path: '**', component: PageNotFoundComponent }

=======
  { path: 'combin', component : CombinaisonComponent},
  { path: '**', component: PageNotFoundComponent },
>>>>>>> 05ef5d1f8311329a0b3e8e12cd796d2e43359ad4
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
    AddWordComponent,
<<<<<<< HEAD
    AddRuleComponent
=======
    CombinaisonComponent
>>>>>>> 05ef5d1f8311329a0b3e8e12cd796d2e43359ad4
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    ReactiveFormsModule,
    FormsModule,
    RouterModule.forRoot(
        appRoutes,
        { enableTracing: true } // <-- debugging purposes only
    ),
    BrowserAnimationsModule,
    MatToolbarModule,
    MatIconModule,
    MatSidenavModule,
    MatButtonModule,
    MatTooltipModule,
    MatTableModule,
    MatProgressSpinnerModule,
    MatFormFieldModule,
    MatOptionModule,
    MatSelectModule,
    MatInputModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
