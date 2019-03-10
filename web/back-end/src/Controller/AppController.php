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
        $res = [];
        foreach ($searchResult as $search) {
            array_push($res, $search->toJSON());
        }
        if(count($res) > 0) {
            $response->setContent(json_encode( $res));
        } else {
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
            $response->setContent(json_encode([]));
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
            $response->setContent(json_encode($word->toJSON()));
        }
        else {
            //$response->setStatusCode(Response::HTTP_NOT_FOUND);
            //$response->setContent(json_encode( 'Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\''));
            $response->setContent(null);
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/add/word", name="addWord", methods={"POST"})
     */
    public function addWord(Request $request) {
        $response = new Response();
        $content = $request->getContent();
        $parametersAsArray = json_decode($content, true);
        try {

            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy($parametersAsArray['word']['category']);
            if (!$category)
                throw new Exception('No category found for id '.$parametersAsArray['word']['category']['id']);
            $word = new Word();
            $word->setCategory($category);
            $word->setValue($parametersAsArray['word']['value']);
            $em  = $this->getDoctrine()->getManager();
            $em->persist($word);
            $em->flush();
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent(json_encode ($word->toJSON()));

        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent(json_encode([$e->getMessage()]));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/update/word/{idWord}", name="editWord", methods={"PUT","PATCH"})
     * @param $idWord
     * @param Request $request
     * @return Response
     */
    public function editWord( $idWord,Request $request) {
        $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
        $data =   json_decode($request->getContent(), true);
        $request->request->replace($data);
        $response = new Response();
        if($word != null) {
            try {
                $category =  $this->getDoctrine()
                    ->getRepository(Category::class)
                    ->findOneBy(array('id' =>$data['category']['id']));
                if(!$category)
                    throw new Exception("category  ".$data['category']['name']." does not exist");
                $word->setCategory($category);
                $word->setValue($data['value']);
                $em  = $this->getDoctrine()->getManager();
                $em->persist($word);
                $em->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(json_encode([$word->toJSON()]));
            } catch (Exception $e) {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $response->setContent(json_encode([$e->getMessage()]));
            }
        }
        else {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            $response->setContent(json_encode( 'Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\''));
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
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent(json_encode('Suppression du mot \'' . $wordDeleteValue . '\' effectuée avec succès'));
        }
        else {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
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
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent(json_encode('Signalemennt du mot \'' . $word->getValue() . '\' effectué avec succès'));
        } else {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
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
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent(json_encode(  $categories));
        } else {
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
            $response->setContent(json_encode( 'Aucune catégories enregistrées.'));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}