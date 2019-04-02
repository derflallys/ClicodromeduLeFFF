import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InfosDialogComponent } from './infos-dialog.component';
import {RouterTestingModule} from '@angular/router/testing';
import {MAT_DIALOG_DATA, MatDialogConfig, MatDialogModule, MatSnackBarModule} from '@angular/material';
import {By} from "@angular/platform-browser";

describe('InfosDialogComponent', () => {
  let component: InfosDialogComponent;
  let fixture: ComponentFixture<InfosDialogComponent>;
  let mockData;
  beforeEach(async(() => {
    mockData = {data: {
        title: 'Import d\'un nouveau lexique',
        content: 'Cet import entrainera une purge complète des données de la base de données actuelles ' +
          'pour y ajouter les nouvelles données.',
        content2: 'Toute erreur pendant l\'ajout des nouvelles données interrompra l\'import. ' +
          'Néanmoins la base aura quand même été purgée.',
        content3: 'Êtes vous sûr de vouloir poursuivre l\'opération ?',
      } };
    TestBed.configureTestingModule({
      declarations: [ InfosDialogComponent ],
      imports: [
        RouterTestingModule,
        MatDialogModule,
        MatSnackBarModule],
      providers: [
        { provide: MAT_DIALOG_DATA, useValue: mockData }
      ]
    })
      .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InfosDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });

});
