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
- `bin/` : Dossier contenant des executables permettant d'automatiser des taches
- `config/` : Dossier contenant les fichiers de configuration de notre projet
- `public/` : Dossier racine du serveur web. 
- `src/` : Contient le code du projet (Entités, Controleurs ect...)
- `templates/` : Dossier contenant les vues de l'application (Inutilisé dans notre projet.)
- `var/` : Dossier contenant les fichiers de cache et de logs 
- `vendor/` : Le dossier utilisé pour stocké les dépendances installées du fichier `composer.json` 
- `.env` : Fichier contenant la configuration de l'environnement d'exécution de notre code
- `composer.json` : Fichier listant les dépendances du projet ainsi que d'autres métadonnées

# Dependances
Voici la liste des dépendances pour le projet (inscrite dans le fichier `composer.json`).  
La partie "require-dev" correspond aux dépendances nécéssaires en développement mais non utilisé en production.

```
"require": {
        "php": "^7.1.3",
        "ext-ctype": "*",
        "ext-iconv": "*",
        "nelmio/cors-bundle": "^1.5",
        "sensio/framework-extra-bundle": "^5.2",
        "symfony/console": "4.2.*",
        "symfony/dotenv": "4.2.*",
        "symfony/flex": "^1.1",
        "symfony/framework-bundle": "4.2.*",
        "symfony/maker-bundle": "^1.11",
        "symfony/orm-pack": "^1.0",
        "symfony/yaml": "4.2.*",
        "symfony/web-server-bundle": "4.2.*"
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