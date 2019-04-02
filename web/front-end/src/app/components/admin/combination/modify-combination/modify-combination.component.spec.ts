import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifyCombinationComponent } from './modify-combination.component';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {ActivatedRoute} from '@angular/router';

describe('ModifyCombinationComponent', () => {
  let component: ModifyCombinationComponent;
  let fixture: ComponentFixture<ModifyCombinationComponent>;
  let mockActivatedRoute;
  beforeEach(async(() => {
    mockActivatedRoute = {
      snapshot: { paramMap: {get: () => { return '1'; }}}
    };
    TestBed.configureTestingModule({
      declarations: [ ModifyCombinationComponent ],
      providers: [
        {provide: ActivatedRoute, useValue: mockActivatedRoute}
      ],
      schemas: [NO_ERRORS_SCHEMA],
    })
        .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModifyCombinationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
