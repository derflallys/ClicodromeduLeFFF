<?php

function writeInFile($category, $line) {
    if(isset($category) && !empty($category) ) {
        $file = fopen("data/". $category . ".txt", 'a');
        fwrite($file, $line);
    } else {
        $file = fopen("data/error.txt", 'a');
        fwrite($file, $line);
    }
}

function help() {
    echo "Usage:\n";
    echo "\tphp parser_mlex.php [options] <fichier>\n\n";
    echo "Aguments:\n";
    echo "\t<fichier> \t Fichier encodé en UTF-8 (Nous nous dégageons de toute responsabilité en cas d'erreur d'encodage). \n\n";
    echo "Le fichier doit respecter un format précis présenté ci-contre:\n";
    echo "\tmot 'tabulation' categorie 'tabulation' lemme 'tabulation' infos_complémentaires\n";
    echo "\t\t[obligatoire] : 'mot' \n";
    echo "\t\t[obligatoire] : 'tabulation'\n";
    echo "\t\t[facultatif]  : 'categorie' : code de la catégorie du mot (ex: verbe=v, adjectif=adj, nom commun=nc, ect...) \n";
    echo "\t\t[obligatoire] : 'tabulation'\n";
    echo "\t\t[obligatoire] : 'lemme \n";
    echo "\t\t[facultatif]  : 'infos_complémentaires : le genre,Mode,Temps ect... (ex: ms qui signifie genre masculin et nombre singulier ,W : infinitif)\n";
    echo "\t\t[obligatoire] : ']'\n";
    echo "Options:\n";
    echo "\t-h \t\t Manuel d'utilisation\n";
    echo "\t--help \t\t Manuel d'utilisation\n\n";
    echo "Exemples:\n";
    echo "\repentir	v	repentir	W\n";
    echo "\trepercement	nc	repercement	ms\n";
    echo "\trepercer	v	repercer	W\n";
}

/**
 * Objectif : Récupérer les mots et leurs nature pour les enregistrer en base
 * Ne pas prendre en compte les formes fléchies
 */
$allLetters = "#[a-zA-ZàâäçéèêëîïôöùûüÿÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸ_]#";

if(isset($argv[1]) && !empty($argv[1]) ) {
    if($argv[1] == "-h" || $argv[1] == "--help") {
        help();
    }
    else {
        $categoryList = [];
        $handle = fopen($argv[1], "r");
        $fp = fopen('result.txt', 'w');
        if ($handle) {
            $categoryList = [];
            while (($line = fgets($handle)) !== false) {
                $write = false;

                if ($line[0] != '#') { // On ne prends pas en compte les commentaires
                    $row = explode("\t", $line);

                    $sub = [];
                    for($i=0;$i<count($row);$i++){
                        if ($row[$i]!=''){
                            array_push($sub,$row[$i]);
                        }
                    }
                    if(count($sub)!=0 && strcmp($sub[0],$sub[2])==0){
                        $word = trim($sub[0]);
                        $category = trim($sub[1]);
                        if (!in_array($category, $categoryList)) {
                            array_push($categoryList, $category);
                        }
                        $lemme = trim($sub[2]);
                        $othersInfos = trim($sub[3]);
                        $write = fwrite($fp, $line);
                    }
                }

            }
            fclose($handle);
            fclose($fp);
            //var_dump($categoryList); //Liste des différentes catégories de mots

            echo "Parsing effectué avec succès ! Le résultat est consultable dans le fichier 'result.txt'.";
        } else {
            echo "Erreur à l'ouverture du fichier '".$argv[1] . "'.";
        }
    }
}
else {
    help();
}

