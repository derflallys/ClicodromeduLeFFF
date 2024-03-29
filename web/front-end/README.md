<p align="center">
    <a href="https://angular.io" target="_blank">
        <img src="https://angular.io/assets/images/logos/angular/angular.svg" width="200">
    </a>
</p>

[Angular](https://angular.io) est un framework Javascript qui facilite la création d'applications avec le Web.
Nous avons choisi d'utiliser ce framework pour l'architecture qu'il propose et par conséquent, la facilité de maintient.
De plus ce framework permet d'offrir des interfaces dynamiques et responsives.

# Installation
Le lancement de l'application nécessite l'installation des dépendances avec la commande :  

    $ npm install
      
Il vous suffit ensuite de lancer l'application avec la/les commande(s) :
   
    $ npm start

ou 

    $ ng serve

Votre application est maintenant lancée sur : [http://localhost:4200](http://localhost:4200) !

# Arborescence
Un projet Angular est composé de plusieurs dossiers :
- `e2e/` : Dossier contenant le code pour executer des tests avec [Protractor](http://www.protractortest.org/)
- `nodes_modules/` : Dossier où sont installées les dépendances du projet
- `src/` : Code source du projet. C'est ici que nous avons implémenté notre code
- `.editorconfig` : Fichier permattant de définir le style de codage pour les éditeurs
- `angular.json` : Configuration pour angular en ligne de commande
- `package.json` : Fichier listant les dépendances du projet ainsi que d'autres métadonnées
- `tsconfig.json` : Configuration pour [TypeScript](https://www.typescriptlang.org/)
- `tslint.json` : Configuration pour [TSLint](https://palantir.github.io/tslint/)

Le dossier `src` est le dossier où l'oin implémente notre code. En voici une présentation plus détaillées :
- `src/app/components` : Contient l'ensemble des composants de l'application. Un composant est défini par 4 fichiers :
  * `NOM_DU_COMPOSANT.compoment.css` : Style inhérent au composant
  * `NOM_DU_COMPOSANT.compoment.html` : Squelette HTML du composant
  * `NOM_DU_COMPOSANT.compoment.ts` : Comportement du composant
  * `NOM_DU_COMPOSANT.compoment.spec.ts` : Fichier de tests du comportement du composant
- `src/app/models` : Contient l'ensemble des modèles de l'application. Un modèle peut s'apparenter à une classe.
- `src/app/services` : Contient l'ensemble des services de l'application. Les services vont effectuer les actions de l'application (requête au back-end...)
- `src/assets` : Contient toutes les images et autres ressources à intégrer sur les pages web 
- `src/environments` : Contient la configuration de l'environnement
- `src/index.html` : La page HTML principale qui est servie lorsque quelqu'un visite l'application. Les modules Javascript et CSS sont ajoutés automatiquement au lancement du serveur.
- `src/main.ts` : Le point d'entrée principal de l'application.

Les autres fichiers du dossier dont des fichiers de configurations auxquels on n'apportera pas de modifications.
Toute notre implémentation est présente dans le dossier `src/app`, le reste est généré par le framework.

# Test unitaires
Pour lancer les tests unitaires relatifs aux composants et aux services de l'application, vous pouvez exécuter la commande :

    $ npm run test
    
Angular utilise Karma et Jasmine pour ces tests. 
Une fenêtre va s'ouvrir dans votre navigateur et indiquera les différents tests exécutés ainsi que leur état (OK ou echec).

# Dependances
Voici la liste des dépendances pour le projet (inscrite dans le fichier `package.json`).  
La partie "devDependencies" correspond aux dépendances nécéssaires en développement mais non utilisé en production.

```
"dependencies": {
    "@angular/animations": "^7.2.10",
    "@angular/cdk": "^7.3.5",
    "@angular/common": "^7.2.10",
    "@angular/compiler": "^7.2.10",
    "@angular/core": "^7.2.10",
    "@angular/flex-layout": "^7.0.0-beta.24",
    "@angular/forms": "^7.2.10",
    "@angular/material": "^7.3.5",
    "@angular/platform-browser": "^7.2.10",
    "@angular/platform-browser-dynamic": "^7.2.10",
    "@angular/router": "^7.2.10",
    "@material-git/grid-list": "^2.0.0-git.20160919",
    "@material/menu": "^1.0.1",
    "core-js": "^2.5.4",
    "file-saver": "^2.0.1",
    "hammerjs": "^2.0.8",
    "rxjs": "~6.3.3",
    "tslib": "^1.9.0",
    "zone.js": "~0.8.26"
  },
  "devDependencies": {
    "@angular-devkit/build-angular": "^0.13.6",
    "@angular/cli": "^7.3.6",
    "@angular/compiler-cli": "^7.2.10",
    "@angular/language-service": "^7.2.10",
    "@types/jasmine": "~2.8.8",
    "@types/jasminewd2": "~2.0.3",
    "@types/node": "~8.9.4",
    "codelyzer": "~4.5.0",
    "jasmine-core": "~2.99.1",
    "jasmine-spec-reporter": "~4.2.1",
    "karma": "^4.0.1",
    "karma-chrome-launcher": "~2.2.0",
    "karma-coverage-istanbul-reporter": "^2.0.5",
    "karma-jasmine": "~1.1.2",
    "karma-jasmine-html-reporter": "^0.2.2",
    "protractor": "~5.4.0",
    "ts-node": "~7.0.0",
    "tslint": "~5.11.0",
    "typescript": "~3.2.2"
  }
```
