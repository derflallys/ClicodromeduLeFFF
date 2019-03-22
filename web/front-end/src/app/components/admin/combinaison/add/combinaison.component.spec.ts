import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CombinaisonComponent } from './combinaison.component';

describe('CombinaisonComponent', () => {
  let component: CombinaisonComponent;
  let fixture: ComponentFixture<CombinaisonComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CombinaisonComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CombinaisonComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
