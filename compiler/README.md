# Parseur LeFFF
Le script "parser_txt.php" est un script permettant de récupérer seulement les mots que l'on souhaite enregistrer en base de données dans un fichier. Il permet donc de supprimer filtrer afin d'évincer toutes les formes fléchies présente.

Ce script fonctionne pour un format particulier de données, voici le manuel d'utilisation du script : 
```
Usage:
        php parser_txt.php [options] <fichier>

Aguments:
        <fichier>        Fichier encodé en UTF-8 (Nous nous dégageons de toute responsabilité en cas d'erreur d'encodage).

Le fichier doit respecter un format précis présenté ci-contre:
        mot 'tabulation' nombre 'tabulation' categorie [pred='infos_du_leme', infos_complémentaires]
                [obligatoire] : 'mot'
                [obligatoire] : 'tabulation'
                [facultatif]  : 'nombre'
                [obligatoire] : 'tabulation'
                [obligatoire] : 'categorie' : code de la catégorie du mot (ex: verbe=v, adjectif=adj, nom commun=nc, ect...)
                [obligatoire] : '['
                [facultatif]  : 'pred='leme_du_mot_SEPARATEUR_<tags>'  :
                        [facultatif]  : 'leme_du_mot' :
                        [facultatif]  : '_SEPARATEUR_' : séparateur composé de 5 underscores et d'un chiffre. (ex: _____1).
                        [facultatif]  : '<tags>' : informations sur les emploi du mot comme les sujet par exemple (ex: <suj:(sn),objde:(de-sn|de-sinf),obja:(à-sinf)>).
                [facultatif]  : 'infos_complémentaires : précédé d'une virgule lorsque qu'un "pred='infos_du_leme'" est renseigné, diverses informations comme la catégorie, le genre ect... (ex: ,cat=nc,@m)
                [obligatoire] : ']'
Options:
        -h               Manuel d'utilisation
        --help           Manuel d'utilisation

Exemples:
        abaissable              adj     [pred='abaissable_____1<suj:(sn),obl:(de-sn|de-sinf|de-scompl|à-sn|à-sinf|à-scompl)>',cat=adj,@s]
        abaissables             adj     [pred='abaissable_____1<suj:(sn),obl:(de-sn|de-sinf|de-scompl|à-sn|à-sinf|à-scompl)>',cat=adj,@p]
```

Le LeFFF est disponible à  ce format à l'adresse suivante : [http://www.labri.fr/perso/clement/lefff/telechargement.html](http://www.labri.fr/perso/clement/lefff/telechargement.html).

## Résultat

Le script permet d'obtenir un fichier "resultat.sql" a executer sur la base de données.
Ce fichier contient un grand nombre de requête, son execution peut donc prendre quelques minutes.


## Avertissement

Le parser ne prend pas en compte l'encodage. On suppose que le format des données est UTF-8. Nous nous dégageons de toute responsabilité en cas d'erreur d'encodage.
Les fichiers disponibles à l'adresse donnée précédemment sont au format ANSI, pensez donc à les convertir en UTF-8.