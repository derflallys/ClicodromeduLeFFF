import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AddCategoryComponent } from './add-category.component';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {FormBuilder} from '@angular/forms';
import {HttpClient, HttpHandler} from '@angular/common/http';
import {RouterTestingModule} from '@angular/router/testing';
import {MatSnackBar, MatSnackBarModule} from '@angular/material';
import {OverlayModule} from '@angular/cdk/overlay';
import {CategoryService} from '../../../../services/category.service';
import {Category} from '../../../../models/Category';
import {Test} from "tslint";

describe('AddCategoryComponent', () => {
  let component: AddCategoryComponent;
  let fixture: ComponentFixture<AddCategoryComponent>;
  const formBuilder: FormBuilder = new FormBuilder();
  let mockCategoryService;

  beforeEach(async(() => {
    mockCategoryService = jasmine.createSpyObj(['addCategory', 'getCategory', 'updateCategory']);
    TestBed.configureTestingModule({
      declarations: [ AddCategoryComponent ],
      schemas: [NO_ERRORS_SCHEMA],
      imports: [RouterTestingModule,
        MatSnackBarModule
      ],
      providers: [
        {provide: FormBuilder, useValue: formBuilder},
        {provide: CategoryService, useValue: mockCategoryService}
      ]
    }).compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AddCategoryComponent);
    component = fixture.componentInstance;
    formBuilder.group({
      code: 'adj',
      name: 'Adjectif'
    });
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });

  it('should have the correct category', () => {
    fixture.componentInstance.category = {id: 1, code: 'adj', name: 'Adjectif'};
    expect(fixture.componentInstance.category.name).toEqual('Adjectif');
  });
  it('should create 2 input for attribute of category', () => {
    const inp = fixture.nativeElement.querySelectorAll('input');
    expect(inp.length).toBe(2);
  });
});
