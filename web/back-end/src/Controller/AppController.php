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
     * @Route("/search/{word}", name="searchWord")
     */
    public function search()
    {}

    /**
     * @Route("/add/{word}", name="addWord")
     */
    public function addWord()
    {}

    /**
     * @Route("/edit/{word}", name="editWord")
     */
    public function editWord()
    {}

    /**
     * @Route("/delete/{word}", name="deleteWord")
     */
    public function deleteWord()
    {}

    /**
     * @Route("/report/{word}", name="reportWord")
     */
    public function reportWord()
    {}
}