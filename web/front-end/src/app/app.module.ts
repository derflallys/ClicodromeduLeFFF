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
import {ModifyWordComponent} from './components/word/modify/modify-word.component';
import {ConsultationComponent} from './components/word/details/consultation.component';
import {ListWordComponent} from './components/word/list/list-word.component';
import {CombinaisonComponent} from './components/admin/combinaison/combinaison.component';
import { AddRuleComponent } from './components/admin/rule/add/add-rule/add-rule.component';
import { AddCategoryComponent } from './components/admin/category/add-category/add-category.component';

import {DeleteDialogComponent} from './components/utils/delete-dialog.component';
import { ImportExportComponent } from './components/import-export/import-export.component';

// Angular Material
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {
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
  MatInputModule,
  MatListModule,
  MatSnackBarModule,
  MatTabsModule,
  MatDialogModule,
  MatGridListModule,
  MatMenuModule,
  MatProgressBarModule,
  MatAutocompleteModule,
} from '@angular/material';
import { FlexLayoutModule } from '@angular/flex-layout';

const appRoutes: Routes = [
  { path: '',
    redirectTo: '/home',
    pathMatch: 'full',
  },
  { path: 'home', component: HomeComponent },
  { path: 'list/:word', component: ListWordComponent },
  { path: 'add', component: AddWordComponent },
  { path: 'modify/:id', component: ModifyWordComponent },
  { path: 'show/:id', component: ConsultationComponent },
  { path: 'admin', component: AdminHomeComponent },
  { path: 'addrule', component: AddRuleComponent },
  { path: 'combin', component : CombinaisonComponent },
  { path: 'category', component :  AddCategoryComponent },
  { path: 'import-export', component : ImportExportComponent },
  { path: '**', component: PageNotFoundComponent },
];

@NgModule({
  exports: [
    // Material
    MatToolbarModule,
    MatAutocompleteModule,
    MatIconModule,
    MatSidenavModule,
    MatButtonModule,
    MatTooltipModule,
    MatTableModule,
    MatProgressSpinnerModule,
    MatFormFieldModule,
    MatOptionModule,
    MatSelectModule,
    MatInputModule,
    MatListModule,
    MatSnackBarModule,
    MatDialogModule,
    MatTabsModule,
    MatDialogModule,
    MatGridListModule,
    MatMenuModule,
    MatProgressBarModule
  ]
})
export class MaterialModule {}

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
    AddRuleComponent,
    CombinaisonComponent,
    DeleteDialogComponent,
    AddCategoryComponent,
    ImportExportComponent
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
    FlexLayoutModule,
    BrowserAnimationsModule,
    MaterialModule,
  ],
  entryComponents: [ DeleteDialogComponent ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {}
