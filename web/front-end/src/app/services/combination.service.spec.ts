import { TestBed } from '@angular/core/testing';

import { CombinationService } from './combination.service';
import {HttpClientTestingModule, HttpTestingController} from '@angular/common/http/testing';
import {environment} from '../../environments/environment';

describe('CombinationService', () => {
  let httpTestingController: HttpTestingController;
  let service: CombinationService;
  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [ HttpClientTestingModule ],
      providers: [
        CombinationService,
      ]
    });
    httpTestingController = TestBed.get(HttpTestingController);
    service = TestBed.get(CombinationService);
  });

  describe('getCombinaison', () => {
    it('should call getCombinaison with the correct URL',  () => {
      service.getCombination(32).subscribe(res => {
        expect(res['combinaison']).toEqual('imparfait;3ps');
      });
      const req = httpTestingController.expectOne(environment.BACK_END_URL + '/get/combination/32');
      req.flush({id: 32, category_id: '30', combinaison: 'imparfait;3ps'});
      httpTestingController.verify();
    });
  });
});
