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
    echo "\tphp parser_txt.php [options] <fichier>\n\n";
    echo "Aguments:\n";
    echo "\t<fichier> \t Fichier encodé en UTF-8 (Nous nous dégageons de toute responsabilité en cas d'erreur d'encodage). \n\n";
    echo "Le fichier doit respecter un format précis présenté ci-contre:\n";
    echo "\tmot 'tabulation' nombre 'tabulation' categorie [pred='infos_du_leme', infos_complémentaires]\n";
    echo "\t\t[obligatoire] : 'mot' \n";
    echo "\t\t[obligatoire] : 'tabulation'\n";
    echo "\t\t[facultatif]  : 'nombre' \n";
    echo "\t\t[obligatoire] : 'tabulation'\n";
    echo "\t\t[obligatoire] : 'categorie' : code de la catégorie du mot (ex: verbe=v, adjectif=adj, nom commun=nc, ect...)\n";
    echo "\t\t[obligatoire] : '['\n";
    echo "\t\t[facultatif]  : 'pred='leme_du_mot_SEPARATEUR_<tags>'  : \n";
    echo "\t\t\t[facultatif]  : 'leme_du_mot' : \n";
    echo "\t\t\t[facultatif]  : '_SEPARATEUR_' : séparateur composé de 5 underscores et d'un chiffre. (ex: _____1).\n";
    echo "\t\t\t[facultatif]  : '<tags>' : informations sur les emploi du mot comme les sujet par exemple (ex: <suj:(sn),objde:(de-sn|de-sinf),obja:(à-sinf)>).\n";
    echo "\t\t[facultatif]  : 'infos_complémentaires : précédé d'une virgule lorsque qu'un \"pred='infos_du_leme'\" est renseigné, diverses informations comme la catégorie, le genre ect... (ex: ,cat=nc,@m)\n";
    echo "\t\t[obligatoire] : ']'\n";
    echo "Options:\n";
    echo "\t-h \t\t Manuel d'utilisation\n";
    echo "\t--help \t\t Manuel d'utilisation\n\n";
    echo "Exemples:\n";
    echo "\tabaissable		adj	[pred='abaissable_____1<suj:(sn),obl:(de-sn|de-sinf|de-scompl|à-sn|à-sinf|à-scompl)>',cat=adj,@s]\n";
    echo "\tabaissables		adj	[pred='abaissable_____1<suj:(sn),obl:(de-sn|de-sinf|de-scompl|à-sn|à-sinf|à-scompl)>',cat=adj,@p]\n";
}

function insertCategory($cat) {
    return "INSERT INTO categorie ('ValueCat') VALUES '" . $cat . "';\n";    
}

function insertWord($word, $cat) {
    return "INSERT INTO word ('ValueWord', 'Idcat') VALUES ('" . $word .
     "', (SELECT 'IdCat' FROM categorie WHERE 'ValueCat' = '". $cat .  "') );\n"; 
}

function insertTags($tag, $word) {
    return "INSERT INTO tags ('valueTag', 'objà', 'objde', 'obj', 'obl', 'IdWord') VALUES (" 
    . "', (SELECT 'IdWord' FROM word WHERE 'ValueWord' = '". $word .  "') );\n"; 
}

/**
 * Objectif : Récupérer les mots et leurs nature pour lese enregistrer en base
 * Ne pas prendre en compte les formes fléchies
 */
$allLetters = "#[a-zA-ZàâäçéèêëîïôöùûüÿÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸ_]#";

if(isset($argv[1]) && !empty($argv[1]) ) {
    if($argv[1] == "-h" || $argv[1] == "--help") {
        help();
    }
    else {
        $handle = fopen($argv[1], "r");
        $fp = fopen('result.txt', 'w');
        if ($handle) {
            $categoryList = [];
            $categoryToImport = [];
            $tagsToImport = [];
            $wordToImport = [];
            while (($line = fgets($handle)) !== false) {
                $write = false;

                if($line[0] != '#') { // On ne prends pas en compte les commentaires
                    $split = explode("\t", $line);

                    //Detection du mot
                    $word = trim($split[0]);

                    //Catégories de mots
                    $category = trim($split[2]);
                    $number =  trim($split[1]);

                    if (!in_array($category, $categoryList)) {
                        array_push($categoryList, $category);
                    }

                    //Récupération des informations du mot
                    $dataWord = trim(end($split));

                    if($dataWord != "[]") {

                        //Detection des tags
                        $tagsSplit = explode("<", $dataWord);
                        if(isset($tagsSplit[1])) {
                            $tags = trim(explode(">", $tagsSplit[1])[0]);
                        }
                        else {
                            $tags = false;
                        }

                        //Detection du mot source
                        $predictionSplit = explode("pred='", $dataWord);
                        if(isset($predictionSplit[1])) {
                            if (strpos($predictionSplit[1], '_____')) {
                                $pred = trim(explode("_____", $predictionSplit[1])[0]);
                            }
                            else if ($tags != false) {
                                $pred = trim(explode("<", $predictionSplit[1])[0]);
                            }
                            else {
                                $pred = trim(explode("'", $predictionSplit[1])[0]);
                            }
                        }
                        else {
                            $pred = false;
                        }

                        //Detection d'autres infos
                        if(!$pred) {
                            $splitting = explode('[', $dataWord)[1];
                            $otherData = trim(explode(']', $splitting)[0]);
                        }
                        else {
                            $splitting = explode("',", $dataWord);
                            if(isset($splitting[1])) {
                                $otherData = trim(explode("]", $splitting[1])[0]);
                            }
                            else {
                                $otherData = false;
                            }
                        }
                    }
                    else {
                        $pred = false;
                        $tags = false;
                        $otherData = false;
                    }

                    /**
                     * TRAITEMENT DU FICHIER
                     */
                    if($pred == false) { // Aucune prédiciton
                        $write = true;
                    }
                    else if (!preg_match($allLetters, $word[0])) { //Caractères (PAS UNE LETTRE)
                        $write = true;
                    }
                    else if ($category == "np") { //Nom propres
                        $write = true;
                    }
                    else if ($category == "poncts") {
                        $write = true;
                    }
                    else if ($category == "ponctw") {
                        $write = true;
                    }
                    else if ($category == "epsilon") {
                        $write = true;
                    }
                    else if ($word == $pred) {
                        $write = true;
                    }

                    /** WRITE HERE */
                    if($write) {
                        if (!in_array($category, $categoryToImport)) { 
                            fwrite($fp, insertCategory($category));
                            array_push($categoryToImport, $category);
                        }
                        fwrite($fp, insertWord($word, $category));
                        if($tags != false) {
                            //fwrite($fp, insertTags($tags));
                        }

                        /*fwrite($fp, "MOT = " . $word . "\n");
                        fwrite($fp, "CAT = " . $category . "\n");
                        fwrite($fp, "PRED = " . $pred . "\n");
                        fwrite($fp, "TAG = " . $tags . "\n");
                        fwrite($fp, "OTHER = " . $otherData . "\n");
                        fwrite($fp, "DATA = " . $dataWord . "\n\n");*/
                    }

                    //Séparation de toutes les catégories de mots
                    //writeInFile($category, $line);
                }
            }

            fclose($handle);
            fclose($fp);
            //var_dump($categoryList); //Liste des différentes catégories de mots

            echo "Parsing effectué avec succès ! Le résultat est consultable dans le fichier 'result.txt'.\n";
        } else {
            echo "Erreur à l'ouverture du fichier '".$argv[1] . "'.\n";
        }
    }
}
else {
    help();
}
?>