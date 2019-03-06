import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { UploadLefffComponent } from './upload-lefff.component';

describe('UploadLefffComponent', () => {
  let component: UploadLefffComponent;
  let fixture: ComponentFixture<UploadLefffComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ UploadLefffComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(UploadLefffComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
