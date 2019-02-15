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
        $response = new Response();
        $response->setContent(json_encode(['code' => 1, "value" => "Homepage"]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/list/word/{word}", name="searchWord")
     */
    public function search(EntityManagerInterface $entityManager, $word) {
        $response = new Response();

        if(!empty($word)) {
            $searchResult = $entityManager->getRepository(Word::class)->searchWord($word);
        } else {
            $searchResult = $entityManager->getRepository(Word::class)->findAll();
        }
        $response->setContent(json_encode(['status' => 1, "searchResult" => $searchResult]));

            $res = [];
            foreach ($searchResult as $search) {
                array_push($res, $search->toJSON());
            }
        if(count($res) > 0) {
            $response->setContent(json_encode(['status' => 1, "nbResult" => count($res), "searchResult" => $res]));
        } else {
            $response->setContent(json_encode(['status' => 0, "nbResult" => count($res), 'msg' => 'Aucun mot ne correspond à la recherche.' ]));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/get/word/{idWord}", name="getWord")
     */
    public function getWord(EntityManagerInterface $entityManager, $idWord) {
        $word = $entityManager->getRepository(Word::class)->findOneBy(['id' => $idWord]);
        $response = new Response();
        if($word != null) {
            $response->setContent(json_encode(['status' => 1, 'word' => $word->toJSON()]));
        }
        else {
            $response->setContent(json_encode(['status' => 0, 'msg' => 'Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\'']));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/add/word", name="addWord")
     */
    public function addWord() {
        $response = new Response();
        $response->setContent(json_encode(['code' => 1, "value" => "ADD_WORD"]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/update/word/{idWord}", name="editWord")
     */
    public function editWord(EntityManagerInterface $entityManager, $idWord) {
        $word = $entityManager->getRepository(Word::class)->findOneBy(['id' => $idWord]);
        $response = new Response();
        if($word != null) {
            $response->setContent(json_encode(['status' => 1, 'word' => $word->toJSON()]));
        }
        else {
            $response->setContent(json_encode(['status' => 0, 'msg' => 'Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\'']));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/delete/word/{idWord}", name="deleteWord")
     */
    public function deleteWord(EntityManagerInterface $entityManager, $idWord) {
        $word = $entityManager->getRepository(Word::class)->findOneBy(['id' => $idWord]);
        $response = new Response();
        if($word != null) {
            $wordDeleteValue = $word->getValue();
            $response->setContent(json_encode(['status' => 1, 'msg' => 'Suppression du mot \'' . $wordDeleteValue . '\' effectuée avec succès']));
        }
        else {
            $response->setContent(json_encode(['status' => 0, 'msg' => 'Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\'']));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/report/word/{idWord}", name="reportWord")
     */
    public function reportWord(EntityManagerInterface $entityManager, $idWord)
    {
        $word = $entityManager->getRepository(Word::class)->findOneBy(['id' => $idWord]);
        $response = new Response();
        if ($word != null) {
            $response->setContent(json_encode(['status' => 1, 'msg' => 'Signalemennt du mot \'' . $word->getValue() . '\' effectué avec succès']));
        } else {
            $response->setContent(json_encode(['status' => 0, 'msg' => 'Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\'']));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/get/category", name="getCategory")
     */
    public function getCategory(EntityManagerInterface $entityManager) {
        $categotiesList = $entityManager->getRepository(Category::class)->findAll();
        $categories = [];
        $response = new Response();
        if(!empty($categotiesList)) {
            foreach ($categotiesList as $cat) {
                array_push($categories, $cat->toJSON());
            }
            $response->setContent(json_encode(['status' => 1 , 'categories' => $categories]));
        } else {
            $response->setContent(json_encode(['status' => 0, 'msg' => 'Aucune catégories enregistrées.']));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}