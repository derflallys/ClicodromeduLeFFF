<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\TagAssociation;

class TagCombinationController extends AbstractController {
    /**
     * @Route("/get/combinaison/{idCategory}", name="getCombinaison", methods={"GET"})
     */
    public function getCombinaison($idCategory) {
        $response = new Response();
        try {

            $category =  $this->getDoctrine()
                ->getRepository(Category::class)
                ->findOneBy(array('id' =>$idCategory));
            if (!$category) {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $response->setContent('No category found for id '.$idCategory);
            }
            $combinaison = $this->getDoctrine()->getRepository(TagAssociation::class)->findByCategory($category->getId());
            if($combinaison != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $combine = [];
                foreach ($combinaison as $combi){
                    array_push($combine,$combi->toJSON());
                }
                $response->setContent(json_encode($combine, JSON_UNESCAPED_UNICODE));
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Aucune combinaison ne correspond à l\'identifiant \'' . $idCategory . '\'');
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/add/combinaison", name="addCombinaison", methods={"POST"})
     */
    public function addCombinaison(Request $request) {
        $response = new Response();
        try {
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy($parametersAsArray['category']);
            if (!$category) {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $response->setContent('No category found for id '. $parametersAsArray['category']['id']);
            }
            else {
                $tagAss = new TagAssociation();
                $tagAss->setCategory($category);
                $tagAss->setCombination($parametersAsArray['combinaison']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($tagAss);
                $em->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($tagAss->toJSON(), JSON_UNESCAPED_UNICODE));
            }

        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
    /**
     * @Route("/delete/combinaison/{idCombinaison}", name="deleteCombinaison", methods={"DELETE"})
     */
    public function deleteCombinaison($idCombinaison) {
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
                $response->setContent('Aucun mot ne correspond à l\'identifiant \'' . $idCombinaison . '\'');
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}