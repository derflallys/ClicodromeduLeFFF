import { TestBed } from '@angular/core/testing';

import { ListWordService } from './list-word.service';

describe('ListWordService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ListWordService = TestBed.get(ListWordService);
    expect(service).toBeTruthy();
  });
});
