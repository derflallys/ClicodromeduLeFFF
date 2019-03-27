import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ListCombinationComponent } from './list-combination.component';

describe('ListRuleComponent', () => {
  let component: ListCombinationComponent;
  let fixture: ComponentFixture<ListCombinationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ListCombinationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ListCombinationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
