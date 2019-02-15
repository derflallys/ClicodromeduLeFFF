<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Word;

class AppController {

    /**
     * @Route("/", name="homepage")
     */
    public function index() {
        return new Response(
            'Index page'
        );
    }

    /**
     * @Route("/list/word/{word}", name="searchWord")
     */
    public function search(EntityManagerInterface $entityManager, $word) {
        $searchResult = $entityManager->getRepository(Word::class)->searchWord($word);

        $res = [];
        foreach ($searchResult as $search) {
            array_push($res, $search->getValue());
        }
        return new Response(
            json_encode($res)
        );
    }

    /**
     * @Route("/get/word/{idWord}", name="getWord")
     */
    public function getWord(EntityManagerInterface $entityManager, $idWord) {
        $word = $entityManager->getRepository(Word::class)->find($idWord);
        $res = [];
        foreach ($word as$w) {
            array_push($res, $w->getValue());
        }
        return new Response(
            json_encode($res)
        );
    }

    /**
     * @Route("/add/word", name="addWord")
     */
    public function addWord() {

        return new Response(
            'ADD WORD'
        );
    }

    /**
     * @Route("/update/word/{idWord}", name="editWord")
     */
    public function editWord(EntityManagerInterface $entityManager, $idWord) {
        $word = $entityManager->getRepository(Word::class)->find($idWord);

        // TODO: EDITION
        return new Response(
            'EDIT WORD'
        );
    }

    /**
     * @Route("/delete/word/{idWord}", name="deleteWord")
     */
    public function deleteWord(EntityManagerInterface $entityManager, $idWord) {
        $word = $entityManager->getRepository(Word::class)->find($idWord);

        // TODO: Suppression
        return new Response(
            'DELETE WORD'
        );
    }

    /**
     * @Route("/report/word/{idWord}", name="reportWord")
     */
    public function reportWord(EntityManagerInterface $entityManager, $idWord) {
        $word = $entityManager->getRepository(Word::class)->find($idWord);

        // TODO: Signalement
        return new Response(
            'REPORT WORD'
        );
    }

    /**
     * @Route("/get/category", name="getCategory")
     */
    public function getCategory(EntityManagerInterface $entityManager) {
        $categotiesList = $entityManager->getRepository(Category::class)->findAll();
        $categories = [];
        foreach ($categotiesList as $cat) {
            array_push($categories, $cat->getName());
        }
        return new Response(
            json_encode($categories)
        );
    }
}