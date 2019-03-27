import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifyCombinationComponent } from './modify-combination.component';

describe('ModifyCombinationComponent', () => {
  let component: ModifyCombinationComponent;
  let fixture: ComponentFixture<ModifyCombinationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModifyCombinationComponent ]
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
