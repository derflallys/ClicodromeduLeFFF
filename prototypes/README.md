# Prototype de génération de formes fléchies
**Attention ces fichiers sont des prototypes, ils fonctionnent toujours mais le fichier SQL généré ne correspond plus à l'architecture actuelle de la base de données et provoquera donc une erreur.**
Dans le dossier `Prototype/`, vous trouverez un premier prototype permettant de générer des fomres fléchies d'un mot.
Nous n'avons pas donné suite à ce prototype car les règles étant écrites directement dans le code source, ne permettaient pas une généricité de notre code.

# Prototypes d'import de lexique
**Attention ces fichiers sont des prototypes, ils fonctionnent toujours mais le fichier SQL généré ne correspond plus à l'architecture actuelle de la base de données et provoquera donc une erreur.**

Ce dossier contient 2 prototypes (`parser_txt.php` et `parser_mlex.php`) permettant de parser des lexique passé en paramètre afin de créer un fichier SQL à importer dans la base de données.

## Parseur LeFFF - TXT
Le script `parser_txt.php` est un script permettant de récupérer seulement les mots que l'on souhaite enregistrer en base de données dans un fichier. 
Il permet donc de filtrer afin d'évincer toutes les formes fléchies présentes.

Ce script fonctionne pour un format particulier de données, voici le manuel d'utilisation du script : 
```
Usage:
        php parser_txt.php [options] <fichier>

Aguments:
        <fichier>        Fichier encodé en UTF-8 (Nous nous dégageons de toute responsabilité en cas d'erreur d'encodage).

Le fichier doit respecter un format précis présenté ci-contre:
        mot 'tabulation' nombre 'tabulation' categorie [pred='infos_du_lemme', infos_complémentaires]
                [obligatoire] : 'mot'
                [obligatoire] : 'tabulation'
                [facultatif]  : 'nombre'
                [obligatoire] : 'tabulation'
                [obligatoire] : 'categorie' : code de la catégorie du mot (ex: verbe=v, adjectif=adj, nom commun=nc, ect...)
                [obligatoire] : '['
                [facultatif]  : 'pred='lemme_du_mot_SEPARATEUR_<tags>'  :
                        [facultatif]  : 'lemme_du_mot' :
                        [facultatif]  : '_SEPARATEUR_' : séparateur composé de 5 underscores et d'un chiffre. (ex: _____1).
                        [facultatif]  : '<tags>' : informations sur les emploi du mot comme les sujet par exemple (ex: <suj:(sn),objde:(de-sn|de-sinf),obja:(à-sinf)>).
                [facultatif]  : 'infos_complémentaires : précédé d'une virgule lorsque qu'un "pred='infos_du_lemme'" est renseigné, diverses informations comme la catégorie, le genre ect... (ex: ,cat=nc,@m)
                [obligatoire] : ']'
Options:
        -h               Manuel d'utilisation
        --help           Manuel d'utilisation

Exemples:
        abaissable              adj     [pred='abaissable_____1<suj:(sn),obl:(de-sn|de-sinf|de-scompl|à-sn|à-sinf|à-scompl)>',cat=adj,@s]
        abaissables             adj     [pred='abaissable_____1<suj:(sn),obl:(de-sn|de-sinf|de-scompl|à-sn|à-sinf|à-scompl)>',cat=adj,@p]
```

Le LeFFF est disponible à ce format à l'adresse suivante : [http://www.labri.fr/perso/clement/lefff/telechargement.html](http://www.labri.fr/perso/clement/lefff/telechargement.html).

## Parseur LeFFF - MLEX

Le script `parser_mlex.php` est fonctionne de la même manière que script "parser_txt.php". 
La différence est qu'il prend entrée le LeFFF au format .mlex. Ce format ne comprend que les formes morphologique des mots. 
Il y a donc moins d'informations a traiter.

Les données sont formatées différemment. Voici donc le manuel d'utilisation du script.
```
Usage:
        php parser_mlex.php [options] <fichier>

Aguments:
        <fichier>        Fichier encodé en UTF-8 (Nous nous dégageons de toute responsabilité en cas d'erreur d'encodage). 

Le fichier doit respecter un format précis présenté ci-contre:
        mot 'tabulation' categorie 'tabulation' lemme 'tabulation' infos_complémentaires
                [obligatoire] : 'mot' 
                [obligatoire] : 'tabulation'
                [facultatif]  : 'categorie' : code de la catégorie du mot (ex: verbe=v, adjectif=adj, nom commun=nc, ect...) 
                [obligatoire] : 'tabulation'
                [obligatoire] : 'lemme 
                [facultatif]  : 'infos_complémentaires : le genre,Mode,Temps ect... (ex: ms qui signifie genre masculin et nombre singulier ,W : infinitif)
                [obligatoire] : ']'
Options:
        -h               Manuel d'utilisation
        --help           Manuel d'utilisation

Exemples:
        repentir v       repentir        W
        repercement     nc      repercement     ms
        repercer        v       repercer        W
```

Le LeFFF est disponible au format MLEX à l'adresse suivante : [https://gforge.inria.fr/frs/download.php/file/34601/lefff-3.4.mlex.tgz](https://gforge.inria.fr/frs/download.php/file/34601/lefff-3.4.mlex.tgz).

## Résultat (NE FONCTIONNE PLUS AVEC L'ARCHITECTURE ACTUELLE)

Ces scripts permettent d'obtenir un fichier "resultat.sql" à executer sur la base de données.
Ce fichier contient un grand nombre de requêtes, son execution peut donc prendre quelques minutes.
Il vous suffit d'executer ce fichier depuis votre interface phpMyAdmin ou bien pour les systèmes UNIX, vous pouvez exécuter la commande :  

    $ mysql -u <username> -p --database=<database_name> < /path/to/compiler/result.sql

## Avertissement

Les parseurs ne prennent pas en compte l'encodage. On suppose que le format des données est UTF-8. Nous nous dégageons de toute responsabilité en cas d'erreur d'encodage.
Les fichiers disponibles à l'adresse [http://www.labri.fr/perso/clement/lefff/telechargement.html](http://www.labri.fr/perso/clement/lefff/telechargement.html) sont au format ANSI, pensez donc à les convertir en UTF-8.