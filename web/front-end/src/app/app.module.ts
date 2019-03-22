import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppComponent} from './app.component';
import {SearchComponent} from './components/word/search/search.component';
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
import { AddRuleComponent } from './components/admin/rule/add-rule/add-rule.component';
import { AddCategoryComponent } from './components/admin/category/add-category/add-category.component';

import {InfosDialogComponent} from './components/utils/infos-dialog.component';
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
  MatAutocompleteModule, MatExpansionModule,
} from '@angular/material';
import { FlexLayoutModule } from '@angular/flex-layout';
import { ListCategoryComponent } from './components/admin/category/list-category/list-category.component';
import { ModifyCategoryComponent } from './components/admin/category/modify-category/modify-category.component';
import { ModifyCombinComponent } from './components/admin/combinaison/modify-combin/modify-combin.component';
import { ListRuleComponent } from './components/admin/rule/list-rule/list-rule.component';
import { ModifyRuleComponent } from './components/admin/rule/add-rule/modify-rule/modify-rule.component';

const appRoutes: Routes = [
  { path: '',
    redirectTo: '/home',
    pathMatch: 'full',
  },
  { path: 'home', component: HomeComponent },
  { path: 'list/word/:word', component: ListWordComponent },
  { path: 'show/word/:id', component: ConsultationComponent },
  { path: 'add/word', component: AddWordComponent },
  { path: 'modify/word/:id', component: ModifyWordComponent },
  { path: 'list/categories', component :  ListCategoryComponent },
  { path: 'add/category', component :  AddCategoryComponent },
  { path: 'modify/category/:id', component :  ModifyCategoryComponent },
  { path: 'list/rules', component :  ListRuleComponent },
  { path: 'addrule', component: AddRuleComponent },
  { path: 'modify/rule/:id', component :  ModifyRuleComponent },
  { path: 'combin', component : CombinaisonComponent },
  { path: 'combin/:id', component : ModifyCombinComponent },
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
    MatProgressBarModule,
    MatExpansionModule
  ],
})
export class MaterialModule {}

@NgModule({
  declarations: [
    AppComponent,
    SearchComponent,
    HomeComponent,
    PageNotFoundComponent,
    ListWordComponent,
    ModifyWordComponent,
    ConsultationComponent,
    AddWordComponent,
    AddRuleComponent,
    CombinaisonComponent,
    InfosDialogComponent,
    AddCategoryComponent,
    ImportExportComponent,
    ListCategoryComponent,
    ModifyCategoryComponent,
    ModifyCombinComponent,
    ListRuleComponent,
    ModifyRuleComponent
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
  entryComponents: [ InfosDialogComponent ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {}
