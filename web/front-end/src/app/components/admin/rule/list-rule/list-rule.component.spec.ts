import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ListRuleComponent } from './list-rule.component';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {RuleService} from '../../../../services/rule.service';
import {CategoryService} from '../../../../services/category.service';
import {MatDialogModule, MatProgressSpinnerModule, MatSnackBarModule, MatTableModule} from '@angular/material';
import {of} from "rxjs";
import {RouterTestingModule} from "@angular/router/testing";

describe('ListRuleComponent', () => {
  let component: ListRuleComponent;
  let fixture: ComponentFixture<ListRuleComponent>;
  let CATEGORIES;
  let RULES;
  let mockRuleService;
  let mockCategoryService;
  beforeEach(async(() => {
    mockCategoryService = jasmine.createSpyObj(['getCategories']);
    mockRuleService = jasmine.createSpyObj(['getAllRules', 'deleteRule']);

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
      declarations: [ ListRuleComponent ],
      schemas: [NO_ERRORS_SCHEMA],
      imports: [MatTableModule,
        RouterTestingModule,
        MatDialogModule,
        MatSnackBarModule,
      ],
      providers: [
        {provide: RuleService, useValue: mockRuleService },
        {provide: CategoryService, useValue: mockCategoryService},

      ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ListRuleComponent);
    component = fixture.componentInstance;
    mockCategoryService.getCategories.and.returnValue(of(CATEGORIES));
    mockRuleService.getAllRules.and.returnValue(of(RULES));
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
