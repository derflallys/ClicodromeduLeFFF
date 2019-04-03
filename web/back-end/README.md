<p align="center"><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_black_02.svg">
</a></p>

[Symfony][1] est un framework PHP pour les applications web. Nous avons choisi d'utiliser ce framework pour les nombreuses fonctionnalités en termes de sécurité, d'architecture de projet ou encore d'interaction avec la base de données.


# Installation
Le lancement de l'application nécessite l'installation des dépendances avec la commande :  

    $ php composer.phar install
      
Il vous suffit ensuite de lancer le serveur avec la commande :
   
    $ php bin/console server:run   

Votre application est maintenant lancée sur : [http://localhost:8000](http://localhost:8000) !

# Arborescence
Un projet symfony est composé de plusieurs dossiers :
- `bin/` : Dossier contenant des executables de dépendances de symfony
- `config/` : Dossier contenant les fichiers de configuration de notre projet
- `public/` : Dossier racine du serveur web. 
- `src/` : Contient le code du projet (Entités, Controleurs ect...)
- `templates/` : Dossier contenant les vues de l'application (Inutilisé dans notre projet.)
- `tests/` : Dossier contenant les tests unitaires de l'application.
- `var/` : Dossier contenant les fichiers de cache et de logs 
- `vendor/` : Le dossier où sont installées les dépendances référencées dans le fichier `composer.json` 
- `.env` : Fichier contenant la configuration de l'environnement d'exécution de notre code
- `composer.json` : Fichier listant les dépendances du projet ainsi que d'autres métadonnées

Toute notre implémentation est présente dans le dossier `src/`, le reste est généré par le framework.

# Test unitaires
Les tests  unitaires ont été implémentés dans le dossier `tests/` de l'application grâce à PHPUnit.
Nous utilisons la dépendance "Guzzle" pour simuler un client.
Pour exécuter les tests, n'oubliez pas de lancer votre serveur web sur le port 8000 avec la commande et de charger les données de tests :
 
     # Lance le serveur web
     $ php bin/console server:run
     
     # Charge les données de tests
     $ php bin/console doctrine:fixtures:load -n
 
Vous pourrez enfin exécuter les tests avec les commandes suivantes : 
```
    # lancer tous les tests de l'application
    $ php bin/phpunit

    # Lancer tous les tests du dossiers Utils/
    $ php bin/phpunit tests/Utils

    # lancer les tests de la classe MaClasse 
    $ php bin/phpunit tests/Util/MaClasseTest.php
```

Vous pouvez ajouter l'option `--testdox` à votre commande pour afficher le nom des tests effectués.

La configuration de PHPUnit, utilisé pour nos tests unitaires se trouve dans le fichier `phpunit.xml.dist`.

# Dependances
Voici la liste des dépendances pour le projet (inscrite dans le fichier `composer.json`).  
La partie "require-dev" correspond aux dépendances nécéssaires en développement mais non utilisé en production.

```
"require": {
        "php": "^7.1.3",
        "ext-ctype": "*",
        "ext-iconv": "*",
        "ext-json": "*",
        "doctrine/doctrine-fixtures-bundle": "^3.1",
        "guzzlehttp/guzzle": "^6.3",
        "nelmio/cors-bundle": "^1.5",
        "sensio/framework-extra-bundle": "^5.2",
        "symfony/browser-kit": "4.2.*",
        "symfony/console": "4.2.*",
        "symfony/dotenv": "4.2.*",
        "symfony/flex": "^1.1",
        "symfony/framework-bundle": "4.2.*",
        "symfony/maker-bundle": "^1.11",
        "symfony/orm-pack": "^1.0",
        "symfony/phpunit-bridge": "4.2.*",
        "symfony/web-server-bundle": "4.2.*",
        "symfony/yaml": "4.2.*"
    },
    "require-dev": {
            "symfony/profiler-pack": "^1.0",
    }
```

# A propos de Symfony

Le développement de Symfony est sponsorisé par [SensioLabs][21],
dirigé par [l'équipe de Symfony][22] et soutenu par les [collaborateurs de Symfony][19].

[1]: https://symfony.com
[19]: https://symfony.com/contributors
[21]: https://sensiolabs.com
[22]: https://symfony.com/doc/current/contributing/code/core_team.html