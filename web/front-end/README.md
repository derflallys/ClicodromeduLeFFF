<p align="center">
    <a href="https://angular.io" target="_blank">
        <img src="https://angular.io/assets/images/logos/angular/angular.svg" style="width: 200px;">
    </a>
</p>

[Angular](https://angular.io) est un framework Javascript qui facilite la création d'applications avec le Web.
Nous avons choisi d'utiliser ce framework pour l'architecture qu'il propose et par conséquent, la facilité de maintient.
De plus ce framework permet d'offrir des interface dynamique et responsives.

# Installation
Le lancement de l'application nécessite l'installation des dépendances avec la commande :  

    $ npm install
      
Il vous suffit ensuite de lancer le serveur avec la/les commande(s) :
   
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
- `src/app` : Contient l'ensemble des composants de l'application. Un composant est défini par 4 fichiers :
  * `NOM_DU_COMPOSANT.compoment.css` : Style inhérent au composant
  * `NOM_DU_COMPOSANT.compoment.html` : Squelette HTML du composant
  * `NOM_DU_COMPOSANT.compoment.ts` : Comportement du composant
  * `NOM_DU_COMPOSANT.compoment.spec.ts` : Fichier de tests du comportement du composant
- `src/assets` : Contient toutes les images et autres ressources à intégrer sur les pages web 
- `src/environments` : Contient la configuration de l'environnement
- `src/index.html` : La page HTML principale qui est servie lorsque quelqu'un visite l'application. Les modules Javascript et CSS sont ajoutés automatiquement au lancement du serveur.
- `src/main.ts` : Le point d'entrée principal de l'application.

Les autres fichiers du dossier dont des fichiers de configurations auxquels on n'apportera pas de modifications.


# Dependances
Voici la liste des dépendances pour le projet (inscrite dans le fichier `package.json`).  
La partie "devDependencies" correspond aux dépendances nécéssaires en développement mais non utilisé en production.

```
"dependencies": {
    "@angular/animations": "~7.2.0",
    "@angular/common": "~7.2.0",
    "@angular/compiler": "~7.2.0",
    "@angular/core": "~7.2.0",
    "@angular/forms": "~7.2.0",
    "@angular/platform-browser": "~7.2.0",
    "@angular/platform-browser-dynamic": "~7.2.0",
    "@angular/router": "~7.2.0",
    "bootstrap": "^4.2.1",
    "core-js": "^2.5.4",
    "jquery": "^3.3.1",
    "rxjs": "~6.3.3",
    "tslib": "^1.9.0",
    "zone.js": "~0.8.26"
  },
  "devDependencies": {
    "@angular-devkit/build-angular": "~0.13.0",
    "@angular/cli": "~7.3.0",
    "@angular/compiler-cli": "~7.2.0",
    "@angular/language-service": "~7.2.0",
    "@types/jasmine": "~2.8.8",
    "@types/jasminewd2": "~2.0.3",
    "@types/node": "~8.9.4",
    "codelyzer": "~4.5.0",
    "font-awesome": "^4.7.0",
    "jasmine-core": "~2.99.1",
    "jasmine-spec-reporter": "~4.2.1",
    "karma": "~3.1.1",
    "karma-chrome-launcher": "~2.2.0",
    "karma-coverage-istanbul-reporter": "~2.0.1",
    "karma-jasmine": "~1.1.2",
    "karma-jasmine-html-reporter": "^0.2.2",
    "protractor": "~5.4.0",
    "ts-node": "~7.0.0",
    "tslint": "~5.11.0",
    "typescript": "~3.2.2"
  }
```