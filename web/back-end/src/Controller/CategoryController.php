<?php

namespace App\Controller;

use App\Entity\PFMRule;
use App\Entity\TagAssociation;
use App\Entity\Word;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class CategoryController extends AbstractController {
    /**
     * @Route("/get/categories", name="getCategories", methods={"GET"})
     */
    public function getCategories() {
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
     * @Route("/get/category/{idCategory}", name="getCategory", methods={"GET"})
     */
    public function getCategory($idCategory) {
        $response = new Response();
        try {
            $category = $this->getDoctrine()->getRepository(Category::class)->find($idCategory);
            if($category != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($category->toJSON(), JSON_UNESCAPED_UNICODE));
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Aucune categorie ne correspond à l\'identifiant : ' . $idCategory);
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
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
            $category = $this->getDoctrine()->getRepository(Category::class)->findDoublons($parametersAsArray['code'], $parametersAsArray['name']);
            if ($category == null) {
                $category = new Category();
                $category->setCode($parametersAsArray['code']);
                $category->setName($parametersAsArray['name']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($category->toJSON(), JSON_UNESCAPED_UNICODE));
            } else {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                $response->setContent("Echec : le code ou le nom de la catégorie renseignée existe déjà.");
            }

        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/update/category/{idCategory}", name="editCategory", methods={"PUT","PATCH"})
     * @param $idCategory
     * @param Request $request
     * @return Response
     */
    public function editCategory( $idCategory,Request $request) {
        $response = new Response();
        try {
            $data = json_decode($request->getContent(), true);
            $existingCategory = $this->getDoctrine()->getRepository(Category::class)->findDoublons($data['code'], $data['name']);
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['id' => $idCategory]);
            if($existingCategory != null && $existingCategory[0]->getId() != $idCategory) {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                $response->setContent("Echec : le code ou le nom de la catégorie renseignée existe déjà.");
            } else {
                if ($category != null) {
                    $category->setCode($data['code']);
                    $category->setName($data['name']);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($category);
                    $em->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent(json_encode($category->toJSON(), JSON_UNESCAPED_UNICODE));
                } else {
                    $response->setStatusCode(Response::HTTP_NOT_FOUND);
                    $response->setContent('Aucune categorie  ne correspond à l\'identifiant : ' . $idCategory);
                }
            }
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
                // Suppression des règles associés
                $rules = $this->getDoctrine()->getRepository(PFMRule::class)->findBy(['category' => $idCategory]);
                foreach ($rules as $rule) {
                    $entityManager->remove($rule);
                }

                // Suppression des tags associés
                $tags = $this->getDoctrine()->getRepository(TagAssociation::class)->findBy(['category' => $idCategory]);
                foreach ($tags as $tag) {
                    $entityManager->remove($tag);
                }

                // Suppression des mots associés
                $words = $this->getDoctrine()->getRepository(Word::class)->findBy(['category' => $idCategory]);
                foreach ($words as $word) {
                    $entityManager->remove($word);
                }

                $entityManager->remove($category);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Aucune categorie ne correspond à l\'identifiant : ' . $idCategory);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}