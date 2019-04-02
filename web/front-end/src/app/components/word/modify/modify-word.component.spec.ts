import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifyWordComponent } from './modify-word.component';
import {WordService} from "../../../services/word.service";
import {ActivatedRoute} from "@angular/router";
import {NO_ERRORS_SCHEMA} from "@angular/core";

describe('ModifyWordComponent', () => {
  let component: ModifyWordComponent;
  let fixture: ComponentFixture<ModifyWordComponent>;
  let mockActivatedRoute;
  beforeEach(async(() => {
    mockActivatedRoute = {
      snapshot: { paramMap: {get: () =>{ return '1';}}}
    };
    TestBed.configureTestingModule({
      declarations: [ ModifyWordComponent ],
      schemas: [NO_ERRORS_SCHEMA],
      providers: [
        {provide: ActivatedRoute, useValue: mockActivatedRoute}

      ],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModifyWordComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
