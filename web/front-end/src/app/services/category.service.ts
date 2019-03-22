import { Injectable } from '@angular/core';
import {Observable} from 'rxjs';
import {Category} from '../models/Category';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {environment} from '../../environments/environment';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json',
  })
};

@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  private categoriesUrl = environment.BACK_END_URL + '/get/categories';
  private addCategoryUrl = environment.BACK_END_URL + '/add/category';
  private deleteCategoryUrl = environment.BACK_END_URL + '/delete/category';
  private updateCategoryUrl = environment.BACK_END_URL + '/update/category';
  private getCategoryUrl = environment.BACK_END_URL + '/get/category';

  constructor(private http: HttpClient) { }

  getCategories(): Observable<Category[]> {
    return this.http.get<Category[]>(this.categoriesUrl);
  }

  addCategory(category: Category) {
    return this.http.post<Response>(this.addCategoryUrl, category, httpOptions);
  }

  deleteCategory(categoryId: number) {
    return this.http.delete<Response>(this.deleteCategoryUrl + '/' + categoryId);
  }

  getCategory(categoryId: number) {
    return this.http.get<Category>(this.getCategoryUrl + '/' + categoryId);
  }

  updateCategory(category: Category, id: number) {
    return this.http.put<Response>(this.updateCategoryUrl + '/' + id, category, httpOptions);
  }
}
