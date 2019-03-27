<?php

namespace App\Controller;

use App\Service\PFM_Interpretor;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Word;

/**
 * Controleur relatif à la gestion des mots du lexique
 * Class WordController
 * @package App\Controller
 */
class WordController extends AbstractController {

    /**
     * Retourne les mots de la base correspondant à la chaine de recherche passé en paramètre
     * @Route("/list/word/{word}", name="searchWord", methods={"GET"})
     * @param $word
     * @return Response
     */
    public function search($word) {
        $response = new Response();
        try {
            if (!empty($word)) {
                $searchResult = $this->getDoctrine()->getRepository(Word::class)->searchWord($word);
            } else {
                $searchResult = $this->getDoctrine()->getRepository(Word::class)->findAll();
            }
            $res = [];
            foreach ($searchResult as $search) {
                array_push($res, $search->toJSON());
            }
            if (count($res) > 0) {
                $response->setContent(json_encode($res, JSON_UNESCAPED_UNICODE));
            } else {
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(json_encode([]));
            }
            $response->headers->set('Content-Type', 'application/json');
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }

    /**
     * Retourne un mot dont l'identifiant est en paramètre (en générant ses formes fléchies)
     * @Route("/get/word/{idWord}", name="getWord", methods={"GET"})
     * @param $idWord
     * @return Response
     */
    public function getWord($idWord) {
        $response = new Response();
        try {
            $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
            if($word != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $interpretor = new PFM_Interpretor();
                $inflectedForms = $interpretor->generateInflectedForm($word);
                $word->setInflectedForms($inflectedForms);
                $response->setContent(json_encode($word->toJSON(), JSON_UNESCAPED_UNICODE));
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Aucun mot ne correspond à l\'identifiant : ' . $idWord);
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }

    /**
     * Retourne un mot dont l'identifiant est en paramètre (SANS générer ses formes fléchies)
     * @Route("/get/wordWithoutForms/{idWord}", name="getWordWithoutForms", methods={"GET"})
     * @param $idWord
     * @return Response
     */
    public function getWordWithoutForms($idWord) {
        $response = new Response();
        try {
            $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
            if($word != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($word->toJSON(), JSON_UNESCAPED_UNICODE));
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Aucun mot ne correspond à l\'identifiant : ' . $idWord);
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }

    /**
     * Ajout d'un nouveau mot
     * @Route("/add/word", name="addWord", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function addWord(Request $request) {
        $response = new Response();
        try {
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy($parametersAsArray['category']);
            $existingWord = $this->getDoctrine()->getRepository(Word::class)->findOneBy(["value" => $parametersAsArray['value'], "tags" => $parametersAsArray['tags'], "category" => $parametersAsArray['category']['id']]);
            //Vérification des doublons
            if ($existingWord != null) {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                $response->setContent("Echec : Ce mot existe déjà avec les tags {" . $parametersAsArray['tags'] . "} dans la catégorie renseignée.");
            } else {
                if (!$category) {
                    $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                    $response->setContent('Aucune categorie ne correspond à l\'identifiant : ' . $parametersAsArray['category']['id']);
                } else {
                    $word = new Word();
                    $word->setCategory($category);
                    $word->setValue($parametersAsArray['value']);
                    $word->setTags($parametersAsArray['tags']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($word);
                    $em->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent(json_encode($word->toJSON(), JSON_UNESCAPED_UNICODE));
                }
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * Modification d'un mot dont l'identifiant est passé en paramètre
     * @Route("/update/word/{idWord}", name="editWord", methods={"PUT","PATCH"})
     * @param $idWord
     * @param Request $request
     * @return Response
     */
    public function editWord($idWord, Request $request) {
        $response = new Response();
        try {
            $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
            $data = json_decode($request->getContent(), true);
            $existingWord = $this->getDoctrine()->getRepository(Word::class)->findOneBy(["value" => $data['value'], "tags" => $data['tags'], "category" => $data['category']['id']]);
            //Vérification des doublons
            if ($existingWord != null && $existingWord->getId() != $idWord) {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                $response->setContent("Echec : Ce mot existe déjà avec les tags {" . $data['tags'] . "} dans la catégorie renseignée.");
            } else {
                if ($word != null) {
                    $category = $this->getDoctrine()
                        ->getRepository(Category::class)
                        ->findOneBy(array('id' => $data['category']['id']));
                    if (!$category) {
                        $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                        $response->setContent("La catégorie  " . $data['category']['name'] . " n'existe pas.");
                    } else {
                        $word->setCategory($category);
                        $word->setValue($data['value']);
                        $word->setTags($data['tags']);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($word);
                        $em->flush();
                        $response->setStatusCode(Response::HTTP_OK);
                        $response->headers->set('Content-Type', 'application/json');
                        $response->setContent(json_encode($word->toJSON(), JSON_UNESCAPED_UNICODE));
                    }
                } else {
                    $response->setStatusCode(Response::HTTP_NOT_FOUND);
                    $response->setContent('Aucun mot ne correspond à l\'identifiant : ' . $idWord);
                }
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * Suppression d'un mot dont l'identifiant est passé en paramètre
     * @Route("/delete/word/{idWord}", name="deleteWord", methods={"DELETE"})
     * @param $idWord
     * @return Response
     */
    public function deleteWord($idWord) {
        $response = new Response();
        try {
            $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
            if($word != null) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($word);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Aucun mot ne correspond à l\'identifiant : ' . $idWord);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}