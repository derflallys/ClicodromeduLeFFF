<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
    public function getWord(EntityManagerInterface $entityManager, $idWord) {
        $word = $entityManager->getRepository(Word::class)->findOneBy(['id' => $idWord]);
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
    public function addWord(EntityManagerInterface $entityManager, Request $request) {
        $response = new Response();
        $parametersAsArray = [];

        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        try {
            $word = new Word();

            $category =  $entityManager
                ->getRepository(Category::class)
                ->findOneBy(array('id' =>$parametersAsArray['word']['category']['id']));
              if (!$category)
                  throw new Exception('No category found for id '.$parametersAsArray['word']['category']['id']);
            $word->setCategory($category);
            $word->setValue($parametersAsArray['word']['value']);


            $entityManager->persist($word);
            $entityManager->flush();
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
        if($word != null) {
            try {

                $category =  $entityManager
                    ->getRepository(Category::class)
                    ->findOneBy(array('id' =>$data['category']['id']));
                $word->setCategory($category);
                $word->setValue($data['value']);

                $entityManager->persist($word);
                $entityManager->flush();
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
    public function deleteWord(EntityManagerInterface $entityManager, $idWord) {
        $word = $entityManager->getRepository(Word::class)->findOneBy(['id' => $idWord]);
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
    public function reportWord(EntityManagerInterface $entityManager, $idWord)
    {
        $word = $entityManager->getRepository(Word::class)->findOneBy(['id' => $idWord]);
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
    public function getCategory(EntityManagerInterface $entityManager) {
        $categotiesList = $entityManager->getRepository(Category::class)->findAll();
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