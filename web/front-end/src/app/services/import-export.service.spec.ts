import { TestBed } from '@angular/core/testing';

import { ImportExportService } from './import-export.service';
import {HttpClientTestingModule, HttpTestingController} from "@angular/common/http/testing";
import {environment} from "../../environments/environment";

describe('ImportExportService', () => {
  let httpTestingController: HttpTestingController;
  let service: ImportExportService;
  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [ HttpClientTestingModule ],
      providers: [
        ImportExportService,
      ]
    });
    httpTestingController = TestBed.get(HttpTestingController);
    service = TestBed.get(ImportExportService);
  });

  describe('doExport', () => {
    it('should call doExport with the correct URL',  () => {
      service.doExport().subscribe();
      const req = httpTestingController.expectOne(environment.BACK_END_URL + '/export');
      expect(req.request.responseType).toBe('blob');
      httpTestingController.verify();
    });
  });
});
