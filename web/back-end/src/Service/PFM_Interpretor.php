<?php

namespace App\Service;

use App\Entity\PFMRule;
use App\Entity\Word;

class PFM_Interpretor {

    public function generateInflectedForm(Word $word, PFMRule $rule) {
        $split = explode("=>", $rule->getRule());
        $desiredResult = $split[1];
        $prefix = explode("+", $desiredResult)[0];
        $rootWord = explode("+", $desiredResult)[1];
        $suffix = explode("+", $desiredResult)[2];
        if($rootWord == "word") {
            $result = $prefix . $word->getValue() . $suffix;
        }
        else if($rootWord == "radical") {
            $radical = str_replace("ll", "", $word->getValue());
            $result = $prefix . $radical . $suffix;
        }
        else {
            $result = $word->getValue();
        }
        return $result;
    }
}