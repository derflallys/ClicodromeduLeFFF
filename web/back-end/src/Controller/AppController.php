<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

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
    public function search($word) {
        $searchResult = $this->getDoctrine()->getRepository(Word::class)->searchWord($word);
        return new Response(
            json_encode($searchResult)
        );
    }

    /**
     * @Route("/get/word/{idWord}", name="addWord")
     */
    public function getWord($idWord) {
        $word = $this->getDoctrine()->getRepository(Word::class)->find($idWord);
        
        return new Response(
            json_encode($word)
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
    public function editWord($idWord) {
        $word = $this->getDoctrine()->getRepository(Word::class)->find($idWord);

        // TODO: EDITION
        return new Response(
            'EDIT WORD'
        );
    }

    /**
     * @Route("/delete/word/{idWord}", name="deleteWord")
     */
    public function deleteWord($idWord) {
        $word = $this->getDoctrine()->getRepository(Word::class)->find($idWord);
        
        // TODO: Suppression
        return new Response(
            'DELETE WORD'
        );
    }

    /**
     * @Route("/report/word/{idWord}", name="reportWord")
     */
    public function reportWord($idWord) {
        $word = $this->getDoctrine()->getRepository(Word::class)->find($idWord);

        // TODO: Signalement
        return new Response(
            'REPORT WORD'
        );
    }

    /**
     * @Route("/get/category", name="getCategory")
     */
    public function getCategory() {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        
        return new Response(
            json_encode($categories)
        );
    }
}