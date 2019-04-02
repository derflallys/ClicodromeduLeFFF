import { TestBed } from '@angular/core/testing';

import { RuleService } from './rule.service';
import {HttpClientTestingModule, HttpTestingController} from '@angular/common/http/testing';
import {environment} from '../../environments/environment';
import {Rule} from '../models/Rule';

describe('RuleService', () => {
  let httpTestingController: HttpTestingController;
  let service: RuleService;
  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [ HttpClientTestingModule ],
      providers: [
        RuleService,
      ]
    });
    httpTestingController = TestBed.get(HttpTestingController);
    service = TestBed.get(RuleService);
  });
  describe('getRule', () => {
    it('should call getRule with the correct URL',  () => {
      service.getRule(37).subscribe(res => {
        expect(res['tag_word']).toEqual('groupe1');
      }
      );
      const req = httpTestingController.expectOne(environment.BACK_END_URL + '/get/rule/37');
      req.flush({id: 37, category_id: '30', application_level: 1, tag_word: 'groupe1', tag_category: 'present;indicatif;3ps', result: '{word}e'});
      httpTestingController.verify();
    });
  });
});
