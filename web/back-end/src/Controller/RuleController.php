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
                $response->setContent('No category found for id '. $parametersAsArray['category']['id']);
            }
            $rule = new PFMRule();
            $rule->setApplicationLevel($parametersAsArray['niveau']);
            $rule->setCategory($category);
            $rule->setResult($parametersAsArray['result']);
            $rule->setTagCategory($parametersAsArray['tagCategory']);
            $rule->setTagWord($parametersAsArray['tagWord']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();
            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($rule->toJSON(), JSON_UNESCAPED_UNICODE));

        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}