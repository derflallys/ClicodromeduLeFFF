import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ListWordComponent } from './list-word.component';
import {MatDialogModule, MatSnackBarModule, MatTableModule} from '@angular/material';
import {RouterTestingModule} from '@angular/router/testing';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {CategoryService} from '../../../services/category.service';
import {WordService} from '../../../services/word.service';
import {of} from 'rxjs';
import {ActivatedRoute} from "@angular/router";

describe('ListWordComponent', () => {
  let component: ListWordComponent;
  let fixture: ComponentFixture<ListWordComponent>;
  let mockCategoryService;
  let mockWordService;
  let CATEGORIES;
  let WORDS;
  let mockActivatedRoute;
  beforeEach(async(() => {
    mockActivatedRoute = {
      snapshot: { paramMap: {get: () => { return 1; }}}
    };
    CATEGORIES = [
      {id: 1, code: 'adj', name: 'Adjectif'},
      {id: 2, code: 'v', name: 'Verbe'},
      {id: 3, code: 'nc', name: 'Nom Commun'}
    ];
    WORDS = [
      {id: 1, value: 'manger', category: CATEGORIES[1], tags: 'groupe1', inflectedForms: []},
      {id: 2, value: 'parler', category: CATEGORIES[1], tags: 'groupe1', inflectedForms: []},
      {id: 3, value: 'finir', category: CATEGORIES[1], tags: 'groupe2', inflectedForms: []}
    ];
    mockCategoryService = jasmine.createSpyObj(['getCategories']);
    mockWordService = jasmine.createSpyObj(['getListWords', 'deleteWord']);
    TestBed.configureTestingModule({
      declarations: [ ListWordComponent ],
      imports: [MatTableModule,
        RouterTestingModule,
        MatDialogModule,
        MatSnackBarModule],
      schemas: [NO_ERRORS_SCHEMA],
      providers: [
        {provide: WordService, useValue: mockWordService},
        {provide: CategoryService, useValue: mockCategoryService},
        {provide: ActivatedRoute, useValue: mockActivatedRoute}

      ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ListWordComponent);
    component = fixture.componentInstance;
    mockCategoryService.getCategories.and.returnValue(of(CATEGORIES));
    mockWordService.getListWords.and.returnValue(of(WORDS));

    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
