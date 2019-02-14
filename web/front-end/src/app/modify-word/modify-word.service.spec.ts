import { TestBed } from '@angular/core/testing';

import { ModifyWordService } from './modify-word.service';

describe('ModifyWordService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ModifyWordService = TestBed.get(ModifyWordService);
    expect(service).toBeTruthy();
  });
});
