import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifyCategoryComponent } from './modify-category.component';
import {ActivatedRoute} from '@angular/router';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {By} from '@angular/platform-browser';
import {AddCategoryComponent} from '../add-category/add-category.component';

describe('ModifyCategoryComponent', () => {
  let component: ModifyCategoryComponent;
  let fixture: ComponentFixture<ModifyCategoryComponent>;
  let mockActivatedRoute;
  beforeEach(async(() => {
    mockActivatedRoute = {
      snapshot: { paramMap: {get: () => { return '1'; }}}
    };
    TestBed.configureTestingModule({
      declarations: [ ModifyCategoryComponent ],
      schemas: [NO_ERRORS_SCHEMA],
      providers: [
        {provide: ActivatedRoute, useValue: mockActivatedRoute}]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModifyCategoryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
  it('should have the AddCategory directive', () => {
    const tab = fixture.debugElement.query(By.css('app-add-category'));
    console.log(tab);
    expect(tab.name).toEqual('app-add-category');
  });
});
