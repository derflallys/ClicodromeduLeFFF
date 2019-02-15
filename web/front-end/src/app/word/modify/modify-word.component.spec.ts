import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifyWordComponent } from './modify-word.component';

describe('ModifyWordComponent', () => {
  let component: ModifyWordComponent;
  let fixture: ComponentFixture<ModifyWordComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModifyWordComponent ]
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
