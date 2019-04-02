import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ListCategoryComponent } from './list-category.component';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {MatDialogModule, MatSnackBarModule, MatTableModule} from '@angular/material';
import {RouterTestingModule} from '@angular/router/testing';
import {CategoryService} from '../../../../services/category.service';
import {of} from 'rxjs';
import {By} from '@angular/platform-browser';


describe('ListCategoryComponent', () => {
  let component: ListCategoryComponent;
  let fixture: ComponentFixture<ListCategoryComponent>;
  let mockCategoryService;
  let CATEGORIES;
  beforeEach(async(() => {
    CATEGORIES = [
      {id: 1, code: 'adj', name: 'Adjectif'},
      {id: 2, code: 'v', name: 'Verbe'},
      {id: 3, code: 'nc', name: 'Nom Commun'}
    ];
    mockCategoryService = jasmine.createSpyObj(['deleteCategory', 'getCategories']);
    TestBed.configureTestingModule({
      declarations: [ ListCategoryComponent],
      schemas: [NO_ERRORS_SCHEMA],
      imports: [MatTableModule,
        RouterTestingModule,
        MatDialogModule,
        MatSnackBarModule,
      ],
      providers: [
        {provide: CategoryService, useValue: mockCategoryService},
      ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ListCategoryComponent);
    component = fixture.componentInstance;
    mockCategoryService.getCategories.and.returnValue(of(CATEGORIES));
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
  it('should set Categories correctly from the service',  () => {
    expect(fixture.componentInstance.categories.length).toBe(3);
  });
  it('should create a table for list of category', () => {
    expect(fixture.debugElement.queryAll(By.css('table')).length).toBe(1);
  });
});
