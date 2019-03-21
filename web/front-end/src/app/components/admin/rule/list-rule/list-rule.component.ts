import { Component, OnInit } from '@angular/core';
import {MatDialog, MatSnackBar, MatTableDataSource} from '@angular/material';
import {Rule} from '../../../../models/Rule';
import {ActivatedRoute, Router} from '@angular/router';
import {CategoryService} from '../../../../services/category.service';
import {RuleService} from '../../../../services/rule.service';
import {Category} from '../../../../models/Category';


@Component({
  selector: 'app-list-rule',
  templateUrl: './list-rule.component.html',
  styleUrls: ['./list-rule.component.css']
})
export class ListRuleComponent implements OnInit {
  allRules: Rule[];
  categories: Category[];
  rulesByCategory: Rule[];
  categorySelected: number;
  categoryNameSelected = '';
  queryTime: string;
  tableWithCategory = false;
  displayedColumns: string[] = ['TagMot', 'Categorie', 'Resultat' , 'Niveau' , 'Régle' , 'actions'];
  loading = {
    status: false,
    color: 'primary',
    mode: 'indeterminate',
    value: 50
  };

  dataSource = new MatTableDataSource();
  dataSourceCat = new MatTableDataSource();
  constructor(
    private router: ActivatedRoute,
    private categoryService: CategoryService,
    private ruleService: RuleService,
    public dialog: MatDialog,
    private route: Router,
    public snackBar: MatSnackBar
  ) { }
  refreshAllRuleTable() {
    this.dataSource = new MatTableDataSource(this.allRules);
  }
  refreshRuleCategoryTable() {
    this.dataSourceCat = new MatTableDataSource(this.rulesByCategory);
  }
  allTab() {
    this.tableWithCategory = false ;
  }
  onSelectCategory($id) {
    this.categorySelected = $id;
    this.categoryNameSelected = this.categories.filter(obj => {
      return obj.id === Number(this.categorySelected);
    })[0].name;

    this.loading.status = true;
    this.ruleService.getRulesByCategory(this.categorySelected).subscribe(
      res => {
        this.rulesByCategory = res;
        this.loading.status = false;
        this.refreshRuleCategoryTable();
        this.tableWithCategory = true;
      },
      error => {
        this.loading.status = false;
        console.log(error);
        this.rulesByCategory  = [];
      }
    );

  }
  ngOnInit() {
    this.rulesByCategory = [];
    this.allRules = [];
    this.loading.status = true;
    this.categoryService.getCategories().subscribe(
      cat => {
        this.categories = cat;
        this.loading.status = false;
      },
    );
    this.loading.status = true;
    this.ruleService.getAllRules().subscribe(
      res => {
        this.allRules = res;
        this.loading.status = false;
        this.refreshAllRuleTable();
      },
      error => {
        console.log(error);
        this.allRules  = [];
      }
    );
  }
  deleteRule(idcat, idrule) {

  }

}
