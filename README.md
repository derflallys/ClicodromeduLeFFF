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

## Manuel d'installation

### **Déploiement d'une base de données**
*Pour déployer la base de données sur windows il faut installer [XAMPP](https://www.apachefriends.org/fr/download.html) 
Une fois installé lancez le logiciel pour afficher le tableau de bord de XAMPP.
Démarrez les serveurs Apache, MySQL en cliquant sur Start.
Aprés sur le navigateur il suffit de taper 127.0.0.1/phpmyadmin pour acceder a l'interface phpMyAdmin et exporter le script web/lefff.sql pour gérer la base de données *

### **Importation d'un lexique en base de données**
*Docs à faire*

### **Lancement de l'application web**
*Docs à faire*


## Pré-requis
Symfony 4 : [PHP](http://php.net/downloads.php) 7.1.3 ou une version supérieure.  
Angular 7 : [NodeJS](https://nodejs.org/en/download/) 8.x or 10.x. ainsi qu'un gestionnaire de package tel que [NPM](https://www.npmjs.com/get-npm).

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
Vous trouverez dans le répertoire ``` compiler ```  le code du compilateur générant les formes fléchies d'un mot. Ce dossier contient aussi les parseur du LeFFF permettant de récupérer les mots a enregistrer en base de données. 
[Plus d'infos sur le compilateur...](compiler/)

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
Le Clicodrome de LeFFF est  un projet universitaire sous [licence MIT](https://opensource.org/licenses/MIT).

