<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class CategoryController extends AbstractController {
    /**
     * @Route("/get/category", name="getCategory", methods={"GET"})
     */
    public function getCategory() {
        $response = new Response();
        try {
            $categotiesList = $this->getDoctrine()->getRepository(Category::class)->findAll();
            $categories = [];
            if(!empty($categotiesList)) {
                foreach ($categotiesList as $cat) {
                    array_push($categories, $cat->toJSON());
                }
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(json_encode($categories, JSON_UNESCAPED_UNICODE));
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
     * @Route("/add/category", name="addCategory", methods={"POST"})
     */
    public function addCategory(Request $request) {
        $response = new Response();
        try {
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $category = new Category();
            $category->setCode($parametersAsArray['code']);
            $category->setName($parametersAsArray['name']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($category->toJSON(), JSON_UNESCAPED_UNICODE));

        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/delete/category/{idCategory}", name="deleteCategory", methods={"DELETE"})
     */
    public function deleteCategory($idCategory) {
        $response = new Response();
        try {
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['id' => $idCategory]);
            if($category != null) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($category);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Aucun mot ne correspond à l\'identifiant \'' . $idCategory . '\'');
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}