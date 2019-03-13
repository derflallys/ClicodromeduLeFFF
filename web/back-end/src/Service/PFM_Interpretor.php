<?php

namespace App\Service;

use App\Entity\PFMRule;
use App\Entity\Word;

class PFM_Interpretor {

    public function generateInflectedForm(Word $word) {
        $result = [];

        /*** Récupération des règles / tags du mot / combianaison de Tags de la catégorie */
        $rules = $word->getCategory()->getRules();
        $tagsWord = explode(";", $word->getTags());
        $tagsCombinations = $word->getCategory()->getTagsAssociations();

        /*** Filtrages des règles selon la correspondances avec les tags du mot */
        $usefulRules = [];
        foreach ($rules as $rule) {
            // Est-ce qu'un tag du mot est renseigné dans la règles ?
            foreach ($tagsWord as $tag) {
                if(in_array($tag, explode(";", $rule->getTagWord())) ) {
                    array_push($usefulRules, $rule);
                    break;
                }
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
                //Si TOUS les tags de la combinaisons sont renseignés dans la règle
                if(!array_diff(explode(";", $tags), explode(";", $r->getTagCategory()))) {
                    array_push($ruleToApply, $r);
                }
            }

            // S'il existe des règles à appliquer
            if(!empty($ruleToApply)) {

                //Si il y a plus d'une règle à appliquer
                if(count($ruleToApply) > 1) {
                    //foreach ($ruleToApply as $rule) {
                    //Tri des règles dans leur ordre d'application (croissant)
                    usort($ruleToApply, function(PFMRule $a, PFMRule $b) {
                        if($a->getApplicationLevel() == $b->getApplicationLevel()){ return 0 ; }
                        return ($a->getApplicationLevel() < $b->getApplicationLevel()) ? -1 : 1;
                    });

                    //Même niveau d'application -> on choisit la plus spécifique
                    //TODO: Garder la règle la plus spécifique
                    //}
                }

                $newForm = "";
                foreach ($ruleToApply as $rule) {
                    //TODO: Application de la/les règle(s)
                    $newForm .= $rule->getApplicationLevel();
                }
                array_push($result, $newForm);
            }
        }

        return $result;
    }
}