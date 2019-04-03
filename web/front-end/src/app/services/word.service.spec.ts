import { TestBed } from '@angular/core/testing';

import { WordService } from './word.service';
import {HttpClientTestingModule, HttpTestingController} from '@angular/common/http/testing';
import {environment} from '../../environments/environment';

describe('WordService', () => {
  let httpTestingController: HttpTestingController;
  let service: WordService;
  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [ HttpClientTestingModule ],
      providers: [
        WordService,
      ]
    });
    httpTestingController = TestBed.get(HttpTestingController);
    service = TestBed.get(WordService);
  });
  describe('getWord', () => {
    it('should call getWord with the correct URL',  () => {
      service.getWord(156).subscribe(res => {
        expect(res['value']).toEqual('abordable');
      });
      const req = httpTestingController.expectOne(environment.BACK_END_URL + '/get/word/156');
      req.flush({id: 156, category_id: '24', value: 'abordable', tags: ''});
      httpTestingController.verify();
    });
  });
});
