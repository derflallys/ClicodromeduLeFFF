import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifyCombinComponent } from './modify-combin.component';

describe('ModifyCombinComponent', () => {
  let component: ModifyCombinComponent;
  let fixture: ComponentFixture<ModifyCombinComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModifyCombinComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModifyCombinComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
