import {Category} from './Category';
import {Tag} from './Tag';

export interface IWord {
  id: number;
  value: string;
  category: Category;
  tags: string;
}
