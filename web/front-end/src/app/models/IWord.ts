import {Category} from './Category';
import {InflectedForm} from './InflectedForm';

export interface IWord {
  id: number;
  value: string;
  category: Category;
  tags: string;
  inflectedForms: InflectedForm[];
}
