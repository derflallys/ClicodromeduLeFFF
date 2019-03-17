import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {Router} from '@angular/router';

@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit {
  @Input() searchInput = '' ;
  @Input() buttonInside = false;
  @Output() inputChanges = new EventEmitter<any>();

  onSubmit() {
    if (this.searchInput.trim() !== '') {
      console.log('INPUT SEARCH : ' + this.searchInput.trim());
      this.router.navigate(['/list', this.searchInput.trim()]);
      this.inputChanges.emit(this.searchInput.trim());
    }
  }
  constructor(private router: Router ) {}

  ngOnInit() {}

}
