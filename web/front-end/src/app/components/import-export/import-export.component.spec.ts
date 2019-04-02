import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ImportExportComponent } from './import-export.component';
import {MatDialogModule, MatSnackBarModule, MatTableModule} from '@angular/material';
import {RouterTestingModule} from '@angular/router/testing';
import {ImportExportService} from '../../services/import-export.service';
import {NO_ERRORS_SCHEMA} from "@angular/core";

describe('ImportExportComponent', () => {
  let component: ImportExportComponent;
  let fixture: ComponentFixture<ImportExportComponent>;
  let mockImportExportService;
  beforeEach(async(() => {
    mockImportExportService = jasmine.createSpyObj(['doExport', 'importSyntaxCustom', 'importSyntaxTxt', 'importSyntaxMlex']);
    TestBed.configureTestingModule({
      declarations: [ ImportExportComponent ],
      imports: [
        RouterTestingModule,
        MatDialogModule,
        MatSnackBarModule],
      schemas: [NO_ERRORS_SCHEMA],
      providers: [
        {provide: ImportExportService, useValue: mockImportExportService}
      ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ImportExportComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
