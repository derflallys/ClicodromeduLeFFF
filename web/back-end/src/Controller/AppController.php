<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Category;
use App\Entity\Word;

class AppController extends AbstractController {

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
    public function search($word) {
        $response = new Response();

        if(!empty($word)) {
            $searchResult = $this->getDoctrine()->getRepository(Word::class)->searchWord($word);
        } else {
            $searchResult = $this->getDoctrine()->getRepository(Word::class)->findAll();
        }
        $response->setContent(json_encode(['status' => 1, "searchResult" => $searchResult]));

        $res = [];
        foreach ($searchResult as $search) {
            array_push($res, $search->toJSON());
        }
        if(count($res) > 0) {
            $response->setContent(json_encode( $res));
        } else {
            $response->setContent(json_encode( 'Aucun mot ne correspond à la recherche.' ));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/get/word/{idWord}", name="getWord")
     */
    public function getWord($idWord) {
        $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
        $response = new Response();
        if($word != null) {
            $response->setContent(json_encode( $word->toJSON()));
        }
        else {
            $response->setContent(json_encode( 'Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\''));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/add/word", name="addWord")
     */
    public function addWord(Request $request) {
        $response = new Response();
        $content = $request->getContent();
        $parametersAsArray = json_decode($content, true);
        try {
            $category = $this->getDoctrine()->getRepository(Category::class)->find($parametersAsArray['word']['category']);
            $word = new Word();
            $word->setCategory($category);
            $word->setValue($parametersAsArray['word']['lemme']);

            $this->getDoctrine()->persist($word);
            $this->getDoctrine()->flush();
            $response->setContent(json_encode(['status' => 200, "word" => $word->toJSON()]));

        } catch (Exception $e) {
            $response->setContent(json_encode(['status' => 500, "msg" => $e->getMessage()]));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/update/word/{idWord}", name="editWord",methods={"PUT","PATCH"})
     * @param EntityManagerInterface $entityManager
     * @param $idWord
     * @param Request $request
     * @return Response
     */
    public function editWord(EntityManagerInterface $entityManager, $idWord,Request $request) {
        $word = $entityManager->getRepository(Word::class)->findOneBy(['id' => $idWord]);
        $data =   json_decode($request->getContent(), true);
        $request->request->replace($data);
       var_dump($data);
        $response = new Response();
        $content = $request->getContent();
        $parametersAsArray = json_decode($content, true);
        if($word != null) {
            try {
                $category = $this->getDoctrine()->getRepository(Category::class)->find($parametersAsArray['word']['category']);
                $word = new Word();
                $word->setCategory($category);
                $word->setValue($parametersAsArray['word']['lemme']);

                $this->getDoctrine()->persist($word);
                $this->getDoctrine()->flush();
                $response->setContent(json_encode(['status' => 200, "word" => $word->toJSON()]));
            } catch (Exception $e) {
                $response->setContent(json_encode(['status' => 500, "msg" => $e->getMessage()]));
            }
        }
        else {
            $response->setContent(json_encode('Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\''));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/delete/word/{idWord}", name="deleteWord")
     */
    public function deleteWord($idWord) {
        $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
        $response = new Response();
        if($word != null) {
            $wordDeleteValue = $word->getValue();
            $response->setContent(json_encode('Suppression du mot \'' . $wordDeleteValue . '\' effectuée avec succès'));
        }
        else {
            $response->setContent(json_encode('Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\''));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/report/word/{idWord}", name="reportWord")
     */
    public function reportWord($idWord)
    {
        $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
        $response = new Response();
        if ($word != null) {
            $response->setContent(json_encode('Signalemennt du mot \'' . $word->getValue() . '\' effectué avec succès'));
        } else {
            $response->setContent(json_encode('Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\''));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/get/category", name="getCategory")
     */
    public function getCategory() {
        $categotiesList = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $categories = [];
        $response = new Response();
        if(!empty($categotiesList)) {
            foreach ($categotiesList as $cat) {
                array_push($categories, $cat->toJSON());
            }
            $response->setContent(json_encode(  $categories));
        } else {
            $response->setContent(json_encode( 'Aucune catégories enregistrées.'));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}