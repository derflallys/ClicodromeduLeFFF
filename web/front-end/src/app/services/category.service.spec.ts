import { TestBed } from '@angular/core/testing';

import { CategoryService } from './category.service';
import {HttpClientTestingModule, HttpTestingController} from '@angular/common/http/testing';
import {environment} from '../../environments/environment';

describe('CategoryService', () => {
  let httpTestingController: HttpTestingController;
  let service: CategoryService;
  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [ HttpClientTestingModule ],
      providers: [
        CategoryService,
      ]
    });
    httpTestingController = TestBed.get(HttpTestingController);
    service = TestBed.get(CategoryService);
  });

  describe('getCategory', () => {
    it('should call getCategory with the correct URL',  () => {
      service.getCategory(24).subscribe(res => {
        expect(res.name).toEqual('adjectif');
      });
      const req = httpTestingController.expectOne(environment.BACK_END_URL + '/get/category/24');
      req.flush({id: 24, code: 'adj', name: 'adjectif'});
      httpTestingController.verify();
    });
  });
});
