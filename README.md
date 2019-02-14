<p align="center" style="display: flex; 
align-items: baseline; 
justify-content: space-evenly;
flex-direction: row";
>
<img src="https://www.u-bordeaux.fr/var/ezdemo_site/storage/images/media/site-institutionnel/images/images-blandine-test/banniere-idv-gif-anime/16065-1-fre-FR/Banniere-idv-gif-anime_Grande.gif" style="width:250px">
<img src="http://www.labri.fr/perso/bpinaud/images/logo-LaBRI-2011.jpg" style="width:100px">
</p>

# Master 1 Informatique - Projet de programmation
-----------------
## Projet : Le Clicodrome de LeFFF

*Présentation du projet à faire*


## Pré-requis
Symfony 4 : [PHP](http://php.net/downloads.php) 7.1.3 ou une version supérieure.  
Angular 7 : [NodeJS](https://nodejs.org/en/download/) 8.x or 10.x. ainsi qu'un gestionnaire de package tel que [NPM](https://www.npmjs.com/get-npm).


## Manuel d'installation

### **Déploiement d'une base de données**
Pour déployer une base de données sur votre machine, il vous faut installer un serveur Apache ainsi que MySQL.   
    
__Pour Windows :__ Installer une plateforme de développement web tels que [XAMPP](https://www.apachefriends.org/fr/download.html) ou [WAMP](http://www.wampserver.com).   
Ces plateforme possède un serveur apache, une ou plusieurs versions de PHP, un serveur MySQL ainsi qu'une interface d'administration de base de données : phpMyAdmin.
Une fois la plateforme lancée vous pouvez accéder aux outils à l'adresse : [http://localhost](http://localhost) ou [http://127.0.0.1](http://127.0.0.1)
  
__Pour Linux :__ Installer un serveur apache avec la commande :  
```sudo apt install apache2```   
Installer MySQL :   
```sudo apt install mysql-server```  
Installer PHP 7.2 : 
```sudo apt install php7.2 php-pear php7.2-curl php7.2-dev php7.2-gd php7.2-mbstring php7.2-zip php7.2-mysql php7.2-xml```  
Installer phpMyAdmin pour administrer vos base de données :   
```sudo apt install phpmyadmin```  

Vous pouvez ensuite relancer votre serveur apache avec la commande :  
```sudo service apache2 restart```

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
`php composer.phar install`  
Puis installer les migrations d'architecture de la base de données avec la commande :  
`php bin/console doctrine:migrations:migrate`

***Félicitations, votre base est enfin configurée et prête à être utilisée !***


### **Importation d'un lexique en base de données**

Afin d'importer le lexique en base de données, on cherche à "filtrer" le LeFFF afin de ne pas enregistrer les formes fléchies.
Cette opération permet d'alléger considérablement le volume de données à enregistrer. (passage d'environ 500 000 entrées à 110 000 entrées environ.)

Dans le dossier [compiler/](compiler/), vous trouverez à votre disposition 2 scripts permettant de faire le filtrage du LeFFF qui leurs est passé en paramètre.
Pour plus de détails sur le fonctionnement des scripts, vous pouvez consulter [le manuel d'utilisation des scripts](compiler/README.md).  
Les 2 scripts génèrent un fichier `resultat.sql` permettant de remplir la base.  
Il vous suffit d'executer ce fichier depuis votre interface phpMyAdmin ou bien pour les système UNIX vous pouvez exécuter la commande :  
`mysql -u username -p password database_name < /path/to/compiler/result.sql`

***Félicitations, les données sont bien présentes dans la base de données !***

### **Lancement de l'application web**

L'application web est divisé en 2 parties. Chacune des parties est bien détaillées dans leur manuel d'installation respectifs.

__Le front__ ([le manuel complet](web/front-end)) : 
Cette partie représente l'interface web. Basé sur le framework javascript Angular 7, 
il faut installer les dépendances du projet à l'aide de la commande à éxécuter à au niveau du code du front [web/front-end/](web/front-end) :  
`npm install`  
Il suffit ensuite de lancer la commande `npm start` executant l'application ensuite disponible à l'adresse : [http://localhost:4200](http://localhost:4200)


__Le back__ ([le manuel complet](web/back-end)) : 
Cette partie gère le traitement des données, ainsi que les interactions avec la base de données.
il faut installer les dépendances du projet à l'aide de la commande à éxécuter à au niveau du code du back [web/back-end/](web/back-end) :  
`php composer.phar install`  
Il suffit ensuite de lancer la commande `php bin/console server:run` executant l'application ensuite disponible à l'adresse : [http://localhost:8000](http://localhost:8000)

L'utilisateur n'a pas besoin de se rendre directement sur l'application du back-end (sur le port 8000).
En effet l'utilisateur va naviguer sur l'application depuis le port 4200. 
Lorsque des données devront être affichées, c'est notre application Angular qui va envoyer une requête vers notre application "serveur" (sur le port 8000) pour récupérer les informations à affichées sur l'interface.

***Félicitations, votre application web est lancée. Rendez-vous à l'adresse [http://localhost:4200](http://localhost:4200) pour y accéder !***


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
[Plus d'infos sur les parseurs...](compiler/)

Vous trouverez dans le répertoire ``` compte_rendus_td ``` les comptes rendus des différents TDs réalisé avec notre chargé de TD, au format [LaTeX](https://www.latex-project.org/).  
[Voir les compte rendus des TDs.](compte_rendus_td/)

Vous trouverez dans le répertoire ``` docs ```  la documentation du projet au format [LaTeX](https://www.latex-project.org/).  
[Consulter la documentation.](docs/)

Vous trouverez dans le répertoire ``` web ```  le code de l'application web du projet. Cette application possède un back-end réalisé en PHP avec [Symfony](https://symfony.com/) et le front réalisé avec [Angular](https://angular.io/).  
[Plus d'infos sur le back-end Symfony...](web/back-end/)   
[Plus d'infos sur le front-end Angular...](web/front-end/)

## L'équipe

* Fatima Ezzahra BAKIR
* Oumayma Jellite
* Guillaume NEDELEC
* Alfred Aboubacar SYLLA
  
## Références

* http://www.labri.fr/perso/clement/lefff/
                            
* http://alpage.inria.fr/~sagot/
                                 
* **Sagot B 2018** *"Informatiser le lexique: Modélisation, développement et exploitation de lexiques morphologiques, syntaxiques et sémantiques"*, HDR in Computer Science, Sorbonne Université, Paris, France
        
* **Clément, L., B. Sagot et B. Lang. 2004**, *« Morphology based automatic acquisition of large- coverage lexica»*, dans Proceedings of the 4th International Conference on Language Resources and Evaluation (LREC 2004), Lisbonne, Portugal, p. 1841–1844.
                 
* **Sagot, B. 2010,** *« The Lefff , a freely available, accurate and large-coverage lexicon for french »*, dans Proceedings of the 7th International Conference on Language Resources and Evaluation (LREC 2010), La Valette, Malte.

## Licence
Le Clicodrome de LeFFF est un projet universitaire - Université de Bordeaux. 

