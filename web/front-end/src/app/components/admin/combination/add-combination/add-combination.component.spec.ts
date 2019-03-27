import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AddCombinationComponent } from './add-combination.component';

describe('AddCombinationComponent', () => {
  let component: AddCombinationComponent;
  let fixture: ComponentFixture<AddCombinationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AddCombinationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AddCombinationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
