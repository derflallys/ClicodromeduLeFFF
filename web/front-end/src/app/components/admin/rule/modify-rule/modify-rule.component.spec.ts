import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifyRuleComponent } from './modify-rule.component';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {ActivatedRoute} from "@angular/router";

describe('ModifyRuleComponent', () => {
  let component: ModifyRuleComponent;
  let fixture: ComponentFixture<ModifyRuleComponent>;
  let mockActivatedRoute;

  beforeEach(async(() => {
    mockActivatedRoute = {
      snapshot: { paramMap: {get: () => { return '1'; }}}
    };
    TestBed.configureTestingModule({
      declarations: [ ModifyRuleComponent ],
      providers: [
        {provide: ActivatedRoute, useValue: mockActivatedRoute}
      ],
      schemas: [NO_ERRORS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModifyRuleComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
