<?php

namespace App\Service;

use PhpParser\Error;

class ExportService {
    public function export($words) {
        try {
            $result = "";
            $pfmInterpretor = new PFM_Interpretor();
            foreach ($words as $word) {
                $line = $word . "\t" . $word->getCategory()->getCode() . "[\"" . $word->getCategory()->getName() . "\"]\tlemme=\"" . $word . "\"\t{" . $word->getTags() . "}\n";
                $result .= $line;
                foreach ($pfmInterpretor->generateInflectedForm($word, true) as $inflectedForm) {
                    $line = $inflectedForm["value"] . "\t\tf[\"forme fléchie\"]\tlemme=\"" . $word . "\"\t{" . $inflectedForm["tags"] . "}\n";
                    $result .= $line;
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw new Error($e);
        }
    }
}