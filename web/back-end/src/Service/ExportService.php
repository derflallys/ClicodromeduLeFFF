<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\PFMRule;
use App\Entity\TagAssociation;
use App\Entity\Word;
use Doctrine\Common\Persistence\ManagerRegistry;
use PhpParser\Error;

/**
 * Service permettant de gérer l'import et l'export du lexique
 * Class ExportService
 * @package App\Service
 */
class ExportService {

    /** Export du lexique prenant en paramètre tous les mots du lexique
     * @param $words
     * @return string
     */
    public function export($words) {
        try {
            $result = "";
            $pfmInterpretor = new PFM_Interpretor();

            // Pour chaque mot du lexique
            foreach ($words as $word) {
                // On ajoute une ligne concernant le mot
                $line = $word . "\t" . $word->getCategory()->getCode() . "[\"" . $word->getCategory()->getName() . "\"]\tlemme=\"" . $word . "\"\t{" . $word->getTags() . "}\n";
                $result .= $line;
                // On génère ses formes fléchies
                foreach ($pfmInterpretor->generateInflectedForm($word, true) as $inflectedForm) {
                    // On ajoute une ligne pour chaque forme fléchie générée
                    $line = $inflectedForm["value"] . "\tf[\"forme fléchie\"]\tlemme=\"" . $word . "\"\t{" . $inflectedForm["tags"] . "}\n";
                    $result .= $line;
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw new Error($e);
        }
    }

    /**
     * Fonction permettant de vider les données de la base (en vue d'un import)
     * @param ManagerRegistry $doctrine
     */
    public function truncateDatabase(ManagerRegistry $doctrine) {
        $em = $doctrine->getManager();
        foreach ($doctrine->getRepository(TagAssociation::class)->findAll() as $tagAsso) {
            $em->remove($tagAsso);
        }
        foreach ($doctrine->getRepository(PFMRule::class)->findAll() as $rule) {
            $em->remove($rule);
        }
        foreach ($doctrine->getRepository(Category::class)->findAll() as $cat) {
            $em->remove($cat);
        }
        foreach ($doctrine->getRepository(Word::class)->findAll() as $word) {
            $em->remove($word);
        }
        $em->flush();
    }

    /**
     * Permet de récupérer le contenu d'un fichier en enlevant les en-têtes
     * @param $fileContent
     * @return mixed
     */
    public function filteringContent($fileContent) {
        $result = explode("\r\n\r\n", $fileContent)[1];
        $result = explode("\r\n------WebKitFormBoundary", $result)[0];
        return $result;
    }

    /**
     * Import d'un lexique dans un format similaire à l'export
     * @param ManagerRegistry $doctrine
     * @param $fileContent
     */
    public function importCustom(ManagerRegistry $doctrine, $fileContent) {
        $lines = explode("\n", $fileContent);
        $em = $doctrine->getManager();
        foreach ($lines as $line) {
            $splitLine = explode("\t", $line);

            // On compte le nombre d'informations sur une ligne pour savoir si on a toutes les informations nécéssaires pour l'import
            if(count($splitLine) == 4) {
                $word = $splitLine[0];
                $categoryInfos = $splitLine[1];
                $lemmesInfos = $splitLine[2];
                $tagsWord = $splitLine[3];
                $categoryCode = explode("[", $categoryInfos)[0];
                $categoryLabel = explode("\"]", explode("[\"", $categoryInfos)[1])[0];
                $lemme = explode("\"", explode("lemme=\"", $lemmesInfos)[1])[0];
                $tags = explode("}", explode("{", $tagsWord)[1])[0];

                // Si le mot n'est pas une forme fléchie -> on l'enregistre
                if ($word == $lemme && $categoryCode != "f" && $categoryLabel != "forme fléchie") {
                    $cat = $doctrine->getRepository(Category::class)->findOneBy(["code" => $categoryCode, "name" => $categoryLabel]);

                    //La catégorie n'existe pas en base, on l'ajoute !
                    if ($cat == null) {
                        $cat = new Category();
                        $cat->setCode($categoryCode);
                        $cat->setName($categoryLabel);
                        $em->persist($cat);
                    }

                    //Ajout du mot
                    $newWord = new Word();
                    $newWord->setValue($word);
                    $newWord->setCategory($cat);
                    $newWord->setTags($tags);
                    $em->persist($newWord);
                }
            }
        }
        $em->flush();
    }

    /**
     * Import d'un lexique au format proposé par Lionel Clement sur son site
     * @param ManagerRegistry $doctrine
     * @param $fileContent
     */
    public function importTxt(ManagerRegistry $doctrine, $fileContent) {
        $lines = explode("\n", $fileContent);
        $em = $doctrine->getManager();
        foreach ($lines as $line) {
            /*$splitLine = explode("\t", $line);
            if(count($splitLine) == 4) {
                $word = $splitLine[0];
                $categoryInfos = $splitLine[1];
                $lemmesInfos = $splitLine[2];
                $tagsWord = $splitLine[3];
                $categoryCode = explode("[", $categoryInfos)[0];
                $categoryLabel = explode("\"]", explode("[\"", $categoryInfos)[1])[0];
                $lemme = explode("\"", explode("lemme=\"", $lemmesInfos)[1])[0];
                $tags = explode("}", explode("{", $tagsWord)[1])[0];

                if ($word == $lemme && $categoryCode != "f" && $categoryLabel != "forme fléchie") {
                    $cat = $doctrine->getRepository(Category::class)->findOneBy(["code" => $categoryCode, "name" => $categoryLabel]);

                    //La catégorie n'existe pas en base, on l'ajoute !
                    if ($cat == null) {
                        $cat = new Category();
                        $cat->setCode($categoryCode);
                        $cat->setName($categoryLabel);
                        $em->persist($cat);
                    }

                    //Ajout du mot
                    $newWord = new Word();
                    $newWord->setValue($word);
                    $newWord->setCategory($cat);
                    $newWord->setTags($tags);
                    $em->persist($newWord);
                    $em->flush();
                }
            }*/
        }
    }

    /**
     * Import d'un lexique au format Mlex disponible sur le site de Benoît Sagot
     * @param ManagerRegistry $doctrine
     * @param $fileContent
     */
    public function importMlex(ManagerRegistry $doctrine, $fileContent) {
        $lines = explode("\n", $fileContent);
        $em = $doctrine->getManager();
        foreach ($lines as $line) {
            $splitLine = explode("\t", $line);
            // On compte le nombre d'arguments sur une ligne pour savoir si toutes les informations nécéssaires à l'import sont disponibles
            if(count($splitLine) >= 2) {
                $word = $splitLine[0];
                $category = $splitLine[1];
                $lemme = $splitLine[2];
                $tagsWord = null;
                $tags = null;
                // On compte le nombre d'argument pour savoir si des tags sont rensignés
                if(count($splitLine) >= 3) {
                    $tagsWord = $splitLine[3];
                }
                // Si le mot n'est pas une forme fléchie
                if ($word == $lemme) {
                    $cat = $doctrine->getRepository(Category::class)->findOneBy(["code" => $category]);

                    //formatage des tags
                    if($tagsWord != null) {
                        $tags = "";
                        foreach (str_split($tagsWord) as $tag) {
                            $tags .= $tag .";";
                        }
                        $tags = substr($tags, 0, -1);
                    }

                    //La catégorie n'existe pas en base, on l'ajoute !
                    if ($cat == null) {
                        $cat = new Category();
                        $cat->setCode($category);
                        $cat->setName($category);
                        $em->persist($cat);
                    }

                    //Ajout du mot
                    $newWord = new Word();
                    $newWord->setValue($word);
                    $newWord->setCategory($cat);
                    $newWord->setTags($tags);
                    $em->persist($newWord);
                }
            }
        }
        $em->flush();
    }
}