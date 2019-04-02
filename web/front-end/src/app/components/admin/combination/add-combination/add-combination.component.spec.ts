import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AddCombinationComponent } from './add-combination.component';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {FormBuilder, Validators} from '@angular/forms';
import {RouterTestingModule} from '@angular/router/testing';
import {CombinationService} from '../../../../services/combination.service';
import {Category} from '../../../../models/Category';
import {CategoryService} from '../../../../services/category.service';
import {MatDialogModule, MatSnackBarModule} from '@angular/material';
import {of} from 'rxjs';

describe('AddCombinationComponent', () => {
  let component: AddCombinationComponent;
  let fixture: ComponentFixture<AddCombinationComponent>;
  const formBuilder: FormBuilder = new FormBuilder();
  let mockCombinaisonService;
  let mockCategoryService;
  let CATEGORIES;
  beforeEach(async(() => {
    CATEGORIES = [
      {id: 1, code: 'adj', name: 'Adjectif'},
      {id: 2, code: 'v', name: 'Verbe'},
      {id: 3, code: 'nc', name: 'Nom Commun'}
    ];
    mockCombinaisonService = jasmine.createSpyObj(['getCombination', 'updateCombination', 'addCombination']);
    mockCategoryService = jasmine.createSpyObj(['getCategories']);
    TestBed.configureTestingModule({
      declarations: [ AddCombinationComponent ],
      imports: [RouterTestingModule,
        MatDialogModule,
        MatSnackBarModule
      ],
      providers: [
        {provide: FormBuilder, useValue: formBuilder},
        {provide: CombinationService, useValue: mockCombinaisonService},
        {provide: CategoryService, useValue: mockCategoryService},
      ],
      schemas: [NO_ERRORS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AddCombinationComponent);
    component = fixture.componentInstance;
    formBuilder.group({
      category: '',
      tagsAssociation: formBuilder.array([]),
    });
    mockCategoryService.getCategories.and.returnValue(of(CATEGORIES));
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
