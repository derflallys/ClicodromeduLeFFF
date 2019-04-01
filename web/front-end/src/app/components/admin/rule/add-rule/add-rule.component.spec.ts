import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AddRuleComponent } from './add-rule.component';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {FormBuilder, Validators} from '@angular/forms';
import {RouterTestingModule} from '@angular/router/testing';
import {MatDialogModule, MatSnackBarModule} from '@angular/material';
import {CombinationService} from '../../../../services/combination.service';
import {CategoryService} from '../../../../services/category.service';
import {RuleService} from '../../../../services/rule.service';
import {of} from "rxjs";

describe('AddRuleComponent', () => {
  let component: AddRuleComponent;
  let fixture: ComponentFixture<AddRuleComponent>;
  const formBuilder: FormBuilder = new FormBuilder();
  let CATEGORIES;
  let RULES;
  let mockRuleService;
  let mockCategoryService;
  beforeEach(async(() => {
    mockCategoryService = jasmine.createSpyObj(['getCategories']);
    mockRuleService = jasmine.createSpyObj(['getRule', 'updateRule', 'addRegle']);
    CATEGORIES = [
      {id: 1, code: 'adj', name: 'Adjectif'},
      {id: 2, code: 'v', name: 'Verbe'},
      {id: 3, code: 'nc', name: 'Nom Commun'}
    ];
    RULES = [
      {
        id: 1,
        wordTags: 'groupe1',
        categoryTags: ' {futur;1pp}',
        category: CATEGORIES[1],
        applicationLevel: 1,
        result: 'issons'
      },
      {
        id: 1,
        wordTags: 'groupe1',
        categoryTags: ' {futur;2pp}',
        category: CATEGORIES[1],
        applicationLevel: 1,
        result: 'issez'
      },
    ];
    TestBed.configureTestingModule({
      declarations: [ AddRuleComponent ],
      schemas: [NO_ERRORS_SCHEMA],
      imports: [RouterTestingModule,
        MatDialogModule,
        MatSnackBarModule
      ],
      providers: [
        {provide: FormBuilder, useValue: formBuilder},
        {provide: RuleService, useValue: mockRuleService},
        {provide: CategoryService, useValue: mockCategoryService},
      ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AddRuleComponent);
    component = fixture.componentInstance;
    formBuilder.group({
      category: '',
      prefix: '',
      suffix: '',
      radical: '',
      wordTags : formBuilder.array([]),
      applicationLevel: 0,
      combinationTags : formBuilder.array([]),
      newRadicalChecked: false,
    });
    mockCategoryService.getCategories.and.returnValue(of(CATEGORIES));
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
