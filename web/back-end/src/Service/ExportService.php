<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\PFMRule;
use App\Entity\TagAssociation;
use App\Entity\Word;
use Doctrine\Common\Persistence\ManagerRegistry;
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
                    $line = $inflectedForm["value"] . "\tf[\"forme fléchie\"]\tlemme=\"" . $word . "\"\t{" . $inflectedForm["tags"] . "}\n";
                    $result .= $line;
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw new Error($e);
        }
    }

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

    public function filteringContent($fileContent) {
        $result = explode("\r\n\r\n", $fileContent)[1];
        $result = explode("\r\n------WebKitFormBoundary", $result)[0];
        return $result;
    }

    public function importCustom(ManagerRegistry $doctrine, $fileContent) {
        $lines = explode("\n", $fileContent);
        $em = $doctrine->getManager();
        foreach ($lines as $line) {
            $splitLine = explode("\t", $line);
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
            }
        }
    }

    public function importTxt(ManagerRegistry $doctrine, $fileContent) {
        $lines = explode("\n", $fileContent);
        $em = $doctrine->getManager();
        foreach ($lines as $line) {
            $splitLine = explode("\t", $line);
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
            }
        }
    }

    public function importMlex(ManagerRegistry $doctrine, $fileContent) {
        $lines = explode("\n", $fileContent);
        $em = $doctrine->getManager();
        foreach ($lines as $line) {
            $splitLine = explode("\t", $line);
            if(count($splitLine) >= 2) {
                $word = $splitLine[0];
                $category = $splitLine[1];
                $lemme = $splitLine[2];
                $tagsWord = null;
                $tags = null;
                if(count($splitLine) >= 3) {
                    $tagsWord = $splitLine[3];
                }
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
                    $em->flush();
                }
            }
        }
    }
}