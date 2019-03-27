<?php

namespace App\Service;

use App\Entity\PFMRule;
use App\Entity\Word;
use Exception;

class PFM_Interpretor {

    /**
     * Génère les formes fléchies d'un mot passé en paramètre
     * @param Word $word
     * @param bool $getTags
     * @return array
     * @throws Exception
     */
    public function generateInflectedForm(Word $word, $getTags = false) {
        $result = [];

        /*** Récupération des règles / tags du mot / combianaison de Tags de la catégorie */
        $rules = $word->getCategory()->getRules();
        $tagsWord = explode(";", $word->getTags());
        $tagsCombinations = $word->getCategory()->getTagsAssociations();

        /*** Filtrages des règles selon la correspondances avec les tags du mot + Récupération des règles définissant le radical du mot*/
        $usefulRules = [];
        foreach ($rules as $rule) {
            $selected = false;
            // Si aucun tag de mot n'est rensigné dans la règle on l'a prend
            if ($rule->getTagWord() == "" || $rule->getTagWord() == null) {
                $selected = true;
            }
            // Est-ce qu'un tag du mot est renseigné dans la règles ?
            foreach ($tagsWord as $tag) {
                if(in_array($tag, explode(";", $rule->getTagWord())) ) {
                    $selected = true;
                    break;
                }
            }
            //Est ce que le mot en lui-même est un tag de la règle
            if(in_array($word->getValue(), explode(";", $rule->getTagWord()))) {
                $selected = true;
            }
            if($selected) {
                array_push($usefulRules, $rule);
            }
        }

        /***
         * Application de chaque règles sur le mot
         *  - Si la règles possède une combinaison de tags correspondant à une combianaison de tag de la catégorie, elle s'applique, sinon elle est ignorée.
         *  - Quand plusieurs règles s'appliquent pour une combinaison données, elles respecte l'odre croissant du niveau d'application
         *  - Si le niveau est le même, la règle la plus spécifique (avec le plus de tags qui correspondent) s'appliquent, les autres sont ignorées.
         */
        foreach ($tagsCombinations as $tags) {
            $ruleToApply = [];

            foreach ($usefulRules as $r) {
                //Si TOUS les tags de la règle sont renseignés dans la combinaisons OU aucun tag n'est rensigné dans la règle
                if(!array_diff(explode(";", $r->getTagCategory()), explode(";", $tags)) || empty($r->getTagCategory()) ) {
                    array_push($ruleToApply, $r);
                }
            }

            // S'il existe des règles à appliquer
            if(!empty($ruleToApply)) {

                //Si il y a plus d'une règle à appliquer
                if(count($ruleToApply) > 1) {

                    //Tri des règles dans leur ordre d'application (croissant)
                    usort($ruleToApply, function(PFMRule $a, PFMRule $b) {
                        if($a->getApplicationLevel() == $b->getApplicationLevel()){ return 0 ; }
                        return ($a->getApplicationLevel() < $b->getApplicationLevel()) ? -1 : 1;
                    });

                    //Même niveau d'application -> on choisit la plus spécifique
                    $newRulesTab = [];
                    //Regroupement des règles du même niveau d'application
                    foreach ($ruleToApply as $rule) {
                        if(!isset($newRulesTab[$rule->getApplicationLevel()])) {
                            $newRulesTab[$rule->getApplicationLevel()] = [];
                        }
                        array_push($newRulesTab[$rule->getApplicationLevel()], $rule);
                    }
                    $ruleToApply = [];
                    //Pour chaque niveau d'application, si il y a plus d'une règles, on choisi la plus spécifique
                    foreach ($newRulesTab as $sortedRule) {
                        if(count($sortedRule)> 1) {
                            $selectedRule = $sortedRule[0];
                            for($i=1; $i < count($sortedRule); $i++) {
                                $nbTagI = count(explode(";", $sortedRule[$i]->getTagCategory()));
                                $nbTagSelect = count(explode(";", $selectedRule->getTagCategory()));
                                if ($nbTagI > $nbTagSelect) {
                                    $selectedRule = $sortedRule[$i];
                                } else if($sortedRule[$i]->getTagCategory() != "" && $selectedRule->getTagCategory() == "" ) {
                                    $selectedRule = $sortedRule[$i];
                                } else {
                                    throw new Exception("Error : Conflict beetween 2 rules with the same number of tags.");
                                }
                            }
                            array_push($ruleToApply, $selectedRule);
                        }
                        else {
                            array_push($ruleToApply, $sortedRule[0]);
                        }
                    }
                }

                //Application de la/les règle(s)
                $newForm = null;
                foreach ($ruleToApply as $rule) {
                    if(strpos($rule->getResult(), "{word}") !== false || strpos($rule->getResult(), "{radical}") !== false) {
                        if(strpos($rule->getResult(), "{word}") !== false) {
                            $newForm = str_replace("{word}", $newForm, $rule->getResult());
                        }
                        else {
                            $newForm = str_replace("{radical}", $newForm, $rule->getResult());
                        }
                    } else {
                        $newForm = $rule->getResult();
                    }
                }
                if(!$getTags) {
                    array_push($result, $newForm);
                } else {
                    $newData["value"] = $newForm;
                    $newData["tags"] = $tags;
                    array_push($result, $newData);
                }
            }
        }

        return $result;
    }
}