import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConsultationComponent } from './consultation.component';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {WordService} from '../../../services/word.service';
import {ActivatedRoute} from '@angular/router';
import {RouterTestingModule} from '@angular/router/testing';
import {MatDialogModule, MatSnackBarModule} from '@angular/material';
import {of} from 'rxjs';

describe('ConsultationComponent', () => {
  let component: ConsultationComponent;
  let fixture: ComponentFixture<ConsultationComponent>;
  let mockWorkService;
  let mockActivatedRoute;
  let WORD;
  let CATEGORIES;
  beforeEach(async(() => {
    mockActivatedRoute = {
      snapshot: { paramMap: {get: () =>{ return '1';}}}
    };
    mockWorkService = jasmine.createSpyObj(['getWord']);
    CATEGORIES = [
      {id: 1, code: 'adj', name: 'Adjectif'},
      {id: 2, code: 'v', name: 'Verbe'},
      {id: 3, code: 'nc', name: 'Nom Commun'}
    ];
    WORD = {id: 1,
    value: 'manger',
    category: CATEGORIES[1],
    tags: 'groupe1',
    inflectedForms: []
    };
    TestBed.configureTestingModule({
      declarations: [ ConsultationComponent ],
      schemas: [NO_ERRORS_SCHEMA],
      imports: [RouterTestingModule,
        MatSnackBarModule,
        MatDialogModule
      ],
      providers: [
        {provide: WordService, useValue: mockWorkService},
        {provide: ActivatedRoute, useValue: mockActivatedRoute}

      ],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConsultationComponent);
    component = fixture.componentInstance;
    mockWorkService.getWord.and.returnValue(of(WORD));
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
