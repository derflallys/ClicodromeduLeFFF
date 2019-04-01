import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InfosDialogComponent } from './infos-dialog.component';

describe('PageNotFoundComponent', () => {
  let component: InfosDialogComponent;
  let fixture: ComponentFixture<InfosDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InfosDialogComponent ]
    })
      .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InfosDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
