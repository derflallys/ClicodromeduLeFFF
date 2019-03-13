<p align="center" style="display: flex; 
align-items: baseline; 
justify-content: space-evenly;
flex-direction: row";
>
<img src="https://www.u-bordeaux.fr/var/ezdemo_site/storage/images/media/site-institutionnel/images/images-blandine-test/banniere-idv-gif-anime/16065-1-fre-FR/Banniere-idv-gif-anime_Grande.gif" width="250">
<img src="http://www.labri.fr/perso/bpinaud/images/logo-LaBRI-2011.jpg" width="100">
</p>

# Master 1 Informatique - Projet de programmation
-----------------

# Sommaire
1. [Projet : Le Clicodrome de LeFFF](#project)
2. [1ère release - 15 février 2019](#realease1)
3. [Release finale - Avril 2019](#releaseFinal)
4. [Pré-requis](#requirements)  
5. [Manuel d'installation](#manuel)  
5.1 [Déploiement d'une base de données](#deployment)  
5.2 [Importation d'un lexique en base de données](#import)  
5.3 [Lancement de l'application web](#launch)
6. [Arborescence du projet](#manuel)
7. [L'équipe](#team)
8. [Références](#references)
9. [Licence](#license)

<a name="project"></a>
## Projet : Le Clicodrome de LeFFF

Le Lexique des formes fĺechies du francais, appelé le **LeFFF** est un lexique contenant des mots ainsi que les formes fléchies de chacun des mots (conjuagison et déclinaisons du mot). 
Aujourd'hui il n'existe pas d'outil permettant d'interagir avec ce lexique, que ce soit pour l'enrichir ou le corriger.
L'objectif du projet est donc de réaliser une application web facilitant la manipulation de ce lexique.  
Pour ce faire, nous allons devoir importer ce lexique dans une base de données et créer des algorithmes permettant de générer les formes fléchies d'un mot afin de ne pas avoir à les enregistrer en base de données.

<a name="realease1"></a>
## 1ère release - 15 février 2019
A ce stade du développment à été développé :
- La base de données
- Les scripts permettant de parser le LeFFF est de générer les données à importer
- L'interface graphique
    * écran d'accueil
    * écran de recherche
    * écran d'ajout d'un mot

- Traitement back-end 
    * Recherche de mot dans la base de données
    * Ajout d'un mot en base de données (début)
    * Consultation d'un mot (sans génération des formes fléchies)

**Objectifs de la seconde release :**
- Modification d'un mot
- Génération des formes fléchies d'un mot
    * Lister l'emsemble des règles PFM
    * Implémenter le comportement de chaque règles
- Importation du lexique depuis l'interface web
- Exportation du lexique (avec ou sans les formes fléchies)
- Gestion des utilisateurs/rôles sur l'application
- Suppression d'un de mot
- Signalement d'un mot
- Gestion des tags
- écran de consultation d'un mot
- écran de modification d'un mot
- Amélioration des écrans existants (Ergonomie)

<a name="releaseFinal"></a>
## Release finale - Avril 2019
*Fonctionnalités à décrire*

<a name="requirements"></a>
## Pré-requis
Symfony 4 : [PHP](http://php.net/downloads.php) 7.1.3 ou une version supérieure.  
Angular 7 : [NodeJS](https://nodejs.org/en/download/) 8.x or 10.x. ainsi qu'un gestionnaire de package tel que [NPM](https://www.npmjs.com/get-npm).

<a name="manuel"></a>
## Manuel d'installation

<a name="deployment"></a>
### **Déploiement d'une base de données**
Pour déployer une base de données sur votre machine, il vous faut installer un serveur Apache ainsi que MySQL.   
    
__Pour Windows :__ Installer une plateforme de développement web tels que [XAMPP](https://www.apachefriends.org/fr/download.html) ou [WAMP](http://www.wampserver.com).   
Ces plateforme possède un serveur apache, une ou plusieurs versions de PHP, un serveur MySQL ainsi qu'une interface d'administration de base de données : phpMyAdmin.
Une fois la plateforme lancée vous pouvez accéder aux outils à l'adresse : [http://localhost](http://localhost) ou [http://127.0.0.1](http://127.0.0.1)
  
__Pour Linux :__ Installer un serveur apache avec la commande :  
    
    $ sudo apt install apache2

Installer MySQL :   
    
    $ sudo apt install mysql-server

Installer PHP 7.2 : 

    $ sudo apt install php7.2 php-pear php7.2-curl php7.2-dev php7.2-gd php7.2-mbstring php7.2-zip php7.2-mysql php7.2-xml  

Installer phpMyAdmin pour administrer vos base de données :   
    
    $ sudo apt install phpmyadmin

Vous pouvez ensuite relancer votre serveur apache avec la commande :  

    $ sudo service apache2 restart

Vous pouvez consultez l'état de votre serveur à l'adresse [http://localhost](http://localhost). Pour accéder à phpMyAdmin, rendez-vous à l'adresse [http://localhost/phpmyadmin](http://localhost/phpmyadmin)

__Création de la base de données de la base:__  
Après avoir configuré les accès pour MySQL/phpMyAdmin, rendez-vous sur PhpMyAdmin, connectez-vous et créez une nouvelle base de données depuis l'interface.  
Nous vous conseillons de nommé votre nouvelle base "pdp-lefff" afin d'évitez des configuration supplémentaires.

__Génération de l'architecture de la base de données :__  
Le framework Symfony et son ORM Doctrine va nous permettre de générer l'architecture de la base automatiquement.  
Pour ce faire rendez-vous dans le dossier [web/back-end](web/back-end) et vérifiez que le fichier `.env` correspond bien à votre configuration précédente.  
La ligne corresponsante est : `DATABASE_URL=mysql://USER:PASSWORD@127.0.0.1:3306/DB_NAME`  
Il vous suffit de remplacer les informations `USER` et `PASSWORD` par les informations que vous avez configuré (souvent "root" et "root").  
Enfin vérifiez que `DB_NAME` correspond bien au nom de votre base de données.

La dernière étape consiste à installer les dépendances du projet avec la commande :  

    $ php composer.phar install

Puis installer les migrations d'architecture de la base de données avec la commande :  
    
    $ php bin/console doctrine:migrations:migrate

***Félicitations, votre base est enfin configurée et prête à être utilisée !***

<a name="import"></a>
### **Importation d'un lexique en base de données**

Si vous souhaitez seulement tester l'application avec des données de tests, nous avons créé un jeu de données permettant de tester les différentes fonctionnalités de l'application web.
Pour installer ces données, il vous suffit de lancer la commande depuis le dossier `web/back-end` :

    $ php bin/console doctrine:fixtures:load
    
Si vous souhaiter importer le lexique "Lefff" complet en base de données, on va le "filtrer" afin de ne pas enregistrer les formes fléchies.
Cette opération permet d'alléger considérablement le volume de données à enregistrer. (passage d'environ 500 000 entrées à 110 000 entrées environ.)

Dans le dossier [compiler/](compiler/), vous trouverez à votre disposition 2 scripts permettant de faire le filtrage du LeFFF qui leurs est passé en paramètre.
Pour plus de détails sur le fonctionnement des scripts, vous pouvez consulter [le manuel d'utilisation des scripts](compiler/README.md).  
Les 2 scripts génèrent un fichier `resultat.sql` permettant de remplir la base.  
Il vous suffit d'executer ce fichier depuis votre interface phpMyAdmin ou bien pour les systèmes UNIX, vous pouvez exécuter la commande :  

    $ mysql -u <username> -p --database=<database_name> < /path/to/compiler/result.sql

***Félicitations, les données sont bien présentes dans la base de données !***

<a name="launch"></a>
### **Lancement de l'application web**

L'application web est divisé en 2 parties. Chacune des parties est bien détaillées dans leur manuel d'installation respectifs.

__Le front__ ([le manuel complet](web/front-end)) : 
Cette partie représente l'interface web. Basé sur le framework javascript Angular 7, 
il faut installer les dépendances du projet à l'aide de la commande à éxecuter à au niveau du code du front [web/front-end/](web/front-end) :  

    $ npm install 
      
Il suffit ensuite de lancer la commande executant l'application ensuite disponible à l'adresse : [http://localhost:4200](http://localhost:4200)

    $ npm start
    
__Le back__ ([le manuel complet](web/back-end)) : 
Cette partie gère le traitement des données, ainsi que les interactions avec la base de données.
il faut installer les dépendances du projet à l'aide de la commande à éxécuter à au niveau du code du back [web/back-end/](web/back-end) :  

    $ php composer.phar install
    
Il suffit ensuite de lancer la commande permettant d'executer l'application à l'adresse : [http://localhost:8000](http://localhost:8000)

    $ php bin/console server:run



L'utilisateur n'a pas besoin de se rendre directement sur l'application du back-end (sur le port 8000).
En effet l'utilisateur va naviguer sur l'application depuis le port 4200. 
Lorsque des données devront être affichées, c'est notre application Angular qui va envoyer une requête vers notre application "serveur" (sur le port 8000) pour récupérer les informations à affichées sur l'interface.

***Félicitations, votre application web est lancée. Rendez-vous à l'adresse [http://localhost:4200](http://localhost:4200) pour y accéder !***

<a name="tree"></a>
## Arborescence du projet
```
.
|-- compiler
|-- compte_rendus_td
|-- docs
|-- web
    |-- back-end
    |-- front-end
```
Vous trouverez dans le répertoire ``` compiler ```  le code des différents parseurs permettant de récupérer toutes les informations du LeFFF a enregistrer dans la base de données.
Ce dossier contient aussi des prototypes de génération de formes fléchies.   
[Plus d'infos sur les parseurs...](compiler/)

Vous trouverez dans le répertoire ``` compte_rendus_td ``` les comptes rendus des différents TDs réalisé avec notre chargé de TD, au format [LaTeX](https://www.latex-project.org/).  
[Voir les compte rendus des TDs.](compte_rendus_td/)

Vous trouverez dans le répertoire ``` docs ```  la documentation du projet au format [LaTeX](https://www.latex-project.org/).  
[Consulter la documentation.](docs/)

Vous trouverez dans le répertoire ``` web ```  le code de l'application web du projet. Cette application possède un back-end réalisé en PHP avec [Symfony](https://symfony.com/) et le front réalisé avec [Angular](https://angular.io/).  
[Plus d'infos sur le back-end Symfony...](web/back-end/)   
[Plus d'infos sur le front-end Angular...](web/front-end/)

<a name="team"></a>
## L'équipe

* Fatima Ezzahra BAKIR
* Oumayma Jellite
* Guillaume NEDELEC
* Alfred Aboubacar SYLLA

<a name="reference"></a>
## Références

* http://www.labri.fr/perso/clement/lefff/
                            
* http://alpage.inria.fr/~sagot/
                                 
* **Sagot B 2018** *"Informatiser le lexique: Modélisation, développement et exploitation de lexiques morphologiques, syntaxiques et sémantiques"*, HDR in Computer Science, Sorbonne Université, Paris, France
        
* **Clément, L., B. Sagot et B. Lang. 2004**, *« Morphology based automatic acquisition of large- coverage lexica»*, dans Proceedings of the 4th International Conference on Language Resources and Evaluation (LREC 2004), Lisbonne, Portugal, p. 1841–1844.
                 
* **Sagot, B. 2010,** *« The Lefff , a freely available, accurate and large-coverage lexicon for french »*, dans Proceedings of the 7th International Conference on Language Resources and Evaluation (LREC 2010), La Valette, Malte.

<a name="license"></a>
## Licence
Le Clicodrome de LeFFF est un projet universitaire - Université de Bordeaux. 

