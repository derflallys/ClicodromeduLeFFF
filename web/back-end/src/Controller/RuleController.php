<?php

namespace App\Controller;

use App\Entity\PFMRule;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class RuleController extends AbstractController {
    /**
     * @Route("/get/rules", name="getRules", methods={"GET"})
     */
    public function getRules() {
        $response = new Response();
        try {
            $rulesList = $this->getDoctrine()->getRepository(PFMRule::class)->findAll();
            $rules = [];
            if(!empty($rulesList)) {
                foreach ($rulesList as $rule) {
                    array_push($rules, $rule->toJSON());
                }
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(json_encode($rules, JSON_UNESCAPED_UNICODE));
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
     * @Route("/get/rule/{idrule}", name="getRule", methods={"GET"})
     */
    public function getRule($idrule) {
        $response = new Response();
        try {
            $rule = $this->getDoctrine()->getRepository(PFMRule::class)->findOneBy(['id' => $idrule]);

            if($rule != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(json_encode($rule->toJSON(), JSON_UNESCAPED_UNICODE));
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
     * @Route("/add/rule", name="addRule", methods={"POST"})
     */
    public function addRule(Request $request) {
        $response = new Response();
        try {
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy($parametersAsArray['category']);
            if (!$category) {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $response->setContent('Aucune categorie ne correspond à l\'identifiant : '. $parametersAsArray['category']['id']);
            }
            $existingRule = $this->getDoctrine()->getRepository(PFMRule::class)->findBy(
                [
                    "category" => $parametersAsArray['category'],
                    "applicationLevel" => $parametersAsArray['applicationLevel'],
                    "tagWord" => $parametersAsArray['wordTags'],
                    "tagCategory" => $parametersAsArray['categoryTags'],
                    "result" => $parametersAsArray['result'],
                ]
            );
            if ($existingRule == null) {
                $rule = new PFMRule();
                $rule->setApplicationLevel($parametersAsArray['applicationLevel']);
                $rule->setCategory($category);
                $rule->setResult($parametersAsArray['result']);
                $rule->setTagCategory($parametersAsArray['categoryTags']);
                $rule->setTagWord($parametersAsArray['wordTags']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($rule);
                $em->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($rule->toJSON(), JSON_UNESCAPED_UNICODE));
            } else {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                $response->setContent("Echec : Une règle comprenant les mêmes paramètres existe déjà.");
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/modify/rule/{idRule}", name="editRule", methods={"PUT","PATCH"})
     * @param $idRule
     * @param Request $request
     * @return Response
     */
    public function editRule($idRule, Request $request) {
        $response = new Response();
        try {
            $rule = $this->getDoctrine()->getRepository(PFMRule::class)->findOneBy(['id' => $idRule]);
            $data = json_decode($request->getContent(), true);
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['id' => $data['category']['id']]);
            if (!$category) {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $response->setContent('Aucune categorie ne correspond à l\'identifiant : '. $data['category']['id']);
            }
            if($rule != null) {
                $existingRule = $this->getDoctrine()->getRepository(PFMRule::class)->findBy(
                    [
                        "category" => $data['category'],
                        "applicationLevel" => $data['applicationLevel'],
                        "tagWord" => $data['wordTags'],
                        "tagCategory" => $data['categoryTags'],
                        "result" => $data['result'],
                    ]
                );
                if ($existingRule != null && $existingRule[0]->getId() != $idRule) {
                    $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                    $response->setContent("Echec : Une règle comprenant les mêmes paramètres existe déjà.");
                } else {
                    $rule->setApplicationLevel($data['applicationLevel']);
                    $rule->setCategory($category);
                    $rule->setResult($data['result']);
                    $rule->setTagCategory($data['categoryTags']);
                    $rule->setTagWord($data['wordTags']);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($rule);
                    $em->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent(json_encode($rule->toJSON(), JSON_UNESCAPED_UNICODE));
                }
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Aucune categorie  ne correspond à l\'identifiant ' . $idRule);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/delete/rule/{idRule}", name="deleteRule", methods={"DELETE"})
     */
    public function deleteRule($idRule) {
        $response = new Response();
        try {
            $category = $this->getDoctrine()->getRepository(PFMRule::class)->findOneBy(['id' => $idRule]);
            if($category != null) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($category);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Aucune categorie ne correspond à l\'identifiant : ' . $idRule);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}