<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController {

    /**
     * @Route("/", name="homepage")
     */
    public function index() {
        return new Response(
            'Index'
        );
    }

    /**
     * @Route("/list/word/{word}", name="searchWord")
     */
    public function search($word) {
        return new Response(
            'Search word'
        );
    }

    /**
     * @Route("/get/word/{word}", name="addWord")
     */
    public function getWord() {
        return new Response(
            'GET WORD'
        );
    }

    /**
     * @Route("/add/word/{word}", name="addWord")
     */
    public function addWord() {
        return new Response(
            'ADD WORD'
        );
    }

    /**
     * @Route("/update/word/{word}", name="editWord")
     */
    public function editWord() {
        return new Response(
            'EDIT WORD'
        );
    }

    /**
     * @Route("/delete/word/{word}", name="deleteWord")
     */
    public function deleteWord() {
        return new Response(
            'DELETE WORD'
        );
    }

    /**
     * @Route("/report/word/{word}", name="reportWord")
     */
    public function reportWord() {
        return new Response(
            'REPORT WORD'
        );
    }

    /**
     * @Route("/get/category/{category}", name="reportWord")
     */
    public function getCategory() {
        return new Response(
            'GET CATEGORY'
        );
    }
}