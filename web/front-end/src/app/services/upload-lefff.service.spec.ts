import { TestBed } from '@angular/core/testing';

import { UploadLefffService } from './upload-lefff.service';

describe('UploadLefffService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: UploadLefffService = TestBed.get(UploadLefffService);
    expect(service).toBeTruthy();
  });
});
