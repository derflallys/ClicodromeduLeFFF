import { TestBed } from '@angular/core/testing';

import { CategoryService } from './category.service';
import {Category} from '../models/Category';

describe('CategoryService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: CategoryService = TestBed.get(CategoryService);
    expect(service).toBeTruthy();
  });
  it('should add Catergory whend addCategory is called',  () => {
    const service: CategoryService = TestBed.get(CategoryService);
    //et newCategory: Category;
  /*  service.addCategory({id: 1, code: 'adj', name: 'Adjectif'}).subscribe(
      res => {
        newCategory = res;
      }
    );*/
   //expect(newCategory.name).toEqual('Adjectif');
  });
});
