import { TestBed } from '@angular/core/testing';

import { AddWordService } from './add-word.service';

describe('AddWordService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: AddWordService = TestBed.get(AddWordService);
    expect(service).toBeTruthy();
  });
});
