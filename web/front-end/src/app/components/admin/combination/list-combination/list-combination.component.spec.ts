import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ListCombinationComponent } from './list-combination.component';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {CombinationService} from '../../../../services/combination.service';
import {CategoryService} from '../../../../services/category.service';
import {ActivatedRoute} from '@angular/router';
import {of} from 'rxjs';
import {MatDialogModule, MatHeaderRowDef, MatSnackBarModule, MatTableModule} from "@angular/material";
import {RouterTestingModule} from "@angular/router/testing";
import {By} from "@angular/platform-browser";

describe('ListCombinationComponent', () => {
  let component: ListCombinationComponent;
  let fixture: ComponentFixture<ListCombinationComponent>;
  let mockCombinaisonService;
  let mockCategoryService;
  let CATEGORIES;
  let COMBINAISONS;
  beforeEach(async(() => {
    CATEGORIES = [
      {id: 1, code: 'adj', name: 'Adjectif'},
      {id: 2, code: 'v', name: 'Verbe'},
      {id: 3, code: 'nc', name: 'Nom Commun'}
    ];
    COMBINAISONS = [
      {id: 1, category: CATEGORIES[1], tagsAssociation: '{futur;1pp}'},
      {id: 2, category: CATEGORIES[1], tagsAssociation: '{present;1pp}'},
    ];
    mockCombinaisonService = jasmine.createSpyObj(['getAllCombinations', 'deleteCombination']);
    mockCategoryService = jasmine.createSpyObj(['getCategories']);
    TestBed.configureTestingModule({
      declarations: [ ListCombinationComponent ],
      imports: [MatTableModule,
        RouterTestingModule,
        MatDialogModule,
        MatSnackBarModule],
      schemas: [NO_ERRORS_SCHEMA],
      providers: [
        {provide: CombinationService, useValue: mockCombinaisonService},
        {provide: CategoryService, useValue: mockCategoryService},
      ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ListCombinationComponent);
    component = fixture.componentInstance;
    mockCategoryService.getCategories.and.returnValue(of(CATEGORIES));
    mockCombinaisonService.getAllCombinations.and.returnValue(of(COMBINAISONS));
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
  it('should set Combinaisons correctly from the service',  () => {
    expect(fixture.componentInstance.combinations.length).toBe(2);
  });
  it('should create a tr for each combinaison', () => {
    const tab = fixture.nativeElement.querySelectorAll('tr.mat-row');
    expect(tab.length).toBe(2);
  });
});
