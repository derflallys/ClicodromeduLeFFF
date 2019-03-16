import { TestBed } from '@angular/core/testing';

import { RegleService } from './regle.service';

describe('RegleService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: RegleService = TestBed.get(RegleService);
    expect(service).toBeTruthy();
  });
});
