import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AddWordComponent } from './add-word.component';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {RouterTestingModule} from '@angular/router/testing';
import {MatSnackBarModule} from '@angular/material';
import {FormBuilder, Validators} from '@angular/forms';
import {CategoryService} from '../../../services/category.service';
import {WordService} from '../../../services/word.service';
import {ActivatedRoute} from '@angular/router';
import {of} from 'rxjs';

describe('AddWordComponent', () => {
  let component: AddWordComponent;
  let fixture: ComponentFixture<AddWordComponent>;
  const formBuilder: FormBuilder = new FormBuilder();
  let mockCategoryService;
  let mockWorkService;
  let mockActivatedRoute;
  let CATEGORIES;
  beforeEach(async(() => {
    mockActivatedRoute = {
      snapshot: { paramMap: {get: () => {return '1';}}}
    };
    CATEGORIES = [
      {id: 1, code: 'adj', name: 'Adjectif'},
      {id: 2, code: 'v', name: 'Verbe'},
      {id: 3, code: 'nc', name: 'Nom Commun'}
    ];
    mockWorkService = jasmine.createSpyObj(['updateWord', 'addWord', 'getWordWithoutInflectedForms']);
    mockCategoryService = jasmine.createSpyObj(['addCategory', 'getCategories', 'updateCategory']);
    TestBed.configureTestingModule({
      declarations: [ AddWordComponent ],
      imports: [RouterTestingModule,
        MatSnackBarModule
      ],
      providers: [
        {provide: FormBuilder, useValue: formBuilder},
        {provide: CategoryService, useValue: mockCategoryService},
        {provide: WordService, useValue: mockWorkService},
        {provide: ActivatedRoute, useValue: mockActivatedRoute}

  ],
      schemas: [NO_ERRORS_SCHEMA]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AddWordComponent);
    component = fixture.componentInstance;
    formBuilder.group({
      lemme: '',
      category: '',
      tags : formBuilder.array([])
    });
    mockCategoryService.getCategories.and.returnValue(of(CATEGORIES));
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
