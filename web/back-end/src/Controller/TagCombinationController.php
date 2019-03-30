<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\TagAssociation;

/**
 * Controleur relatif à la gestion des associations de tags des catégories
 * Class TagCombinationController
 * @package App\Controller
 */
class TagCombinationController extends AbstractController {

    /**
     * Retourne l'ensemble des associations enregistrées en base de données
     * @Route("/get/combinations", name="getAllCombinations", methods={"GET"})
     * @return Response
     */
    public function getCombinations() {
        $response = new Response();
        try {
            $combinList = $this->getDoctrine()->getRepository(TagAssociation::class)->findAll();
            $combinations = [];
            if(!empty($combinList)) {
                foreach ($combinList as $combin) {
                    array_push($combinations, $combin->toJSON());
                }
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(json_encode($combinations, JSON_UNESCAPED_UNICODE));
            } else {
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(json_encode([]));
            }
            $response->headers->set('Content-Type', 'application/json');
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * Retourne une combinaison ciblé par l'identifiant passé en paramètre
     * @Route("/get/combination/{idCombination}", name="getCombination", methods={"GET"})
     * @param $idCombination
     * @return Response
     */
    public function getCombination($idCombination) {
        $response = new Response();
        try {
            $combinaison = $this->getDoctrine()->getRepository(TagAssociation::class)->findOneBy(['id' => $idCombination]);
            if($combinaison != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($combinaison->toJSON(), JSON_UNESCAPED_UNICODE));
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Aucune combinaison ne correspond à l\'identifiant : ' . $idCombination);
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }

    /**
     * Ajout d'une nouvelle association de tags
     * @Route("/add/combination", name="addCombination", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function addCombination(Request $request) {
        $response = new Response();
        try {
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy($parametersAsArray['category']);
            if (!$category) {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $response->setContent('Aucune categorie ne correspond à l\'identifiant : '. $parametersAsArray['category']['id']);
            }
            else {
                // Vérification des doublons
                $existingCombination = $this->getDoctrine()->getRepository(TagAssociation::class)->findBy(
                    [
                        "category" => $parametersAsArray['category'],
                        "combination" => $parametersAsArray['tagsAssociation']
                    ]
                );
                if ($existingCombination == null) {
                    $tagAss = new TagAssociation();
                    $tagAss->setCategory($category);
                    $tagAss->setCombination($parametersAsArray['tagsAssociation']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($tagAss);
                    $em->flush();
                    $response->setStatusCode(Response::HTTP_CREATED);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent(json_encode($tagAss->toJSON(), JSON_UNESCAPED_UNICODE));
                } else {
                    $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                    $response->setContent("Echec : Cette combinaison existe déjà pour cette catégorie.");
                }
            }

        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * Modification d'une association dont l'identifiant est passé en paramètre
     * @Route("/update/combination/{idCombination}", name="editCombinaison", methods={"PUT","PATCH"})
     * @param $idCombination
     * @param Request $request
     * @return Response
     */
    public function editCombination($idCombination, Request $request) {
        $response = new Response();
        try {
            $combinaison = $this->getDoctrine()->getRepository(TagAssociation::class)->findOneBy(['id' => $idCombination]);
            $data = json_decode($request->getContent(), true);
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['id' => $data['category']['id']]);
            if (!$category) {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $response->setContent('Aucune categorie ne correspond à l\'identifiant : '. $data['category']['id']);
            }
            if($combinaison != null) {
                // Vérification des doublons
                $existingCombination = $this->getDoctrine()->getRepository(TagAssociation::class)->findBy(
                    [
                        "category" => $data['category'],
                        "combination" => $data['tagsAssociation']
                    ]
                );
                if ($existingCombination != null && $existingCombination[0]->getId() != $idCombination) {
                    $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                    $response->setContent("Echec : Cette combinaison existe déjà pour cette catégorie.");
                } else {
                    $combinaison->setCategory($category);
                    $combinaison->setCombination($data['tagsAssociation']);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($combinaison);
                    $em->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent(json_encode($combinaison->toJSON(), JSON_UNESCAPED_UNICODE));
                }
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Aucune combinaison  ne correspond à l\'identifiant : ' . $idCombination);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * Supprime une association de tags dont l'identifiant est passé en paramètre
     * @Route("/delete/combination/{idCombinaison}", name="deleteCombinaison", methods={"DELETE"})
     * @param $idCombinaison
     * @return Response
     */
    public function deleteCombination($idCombinaison) {
        $response = new Response();
        try {
            $tagAssoc = $this->getDoctrine()->getRepository(TagAssociation::class)->findOneBy(['id' => $idCombinaison]);
            if($tagAssoc != null) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($tagAssoc);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Aucune combinaison ne correspond à l\'identifiant : ' . $idCombinaison);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}