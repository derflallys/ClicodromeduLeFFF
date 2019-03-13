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
     * @Route("/list/word/{word}", name="searchWord", methods={"GET"})
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
                $response->setContent(json_encode($res));
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
     * @Route("/get/word/{idWord}", name="getWord", , methods={"GET"})
     */
    public function getWord($idWord) {
        $response = new Response();
        try {
            $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
            if($word != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($word->toJSON()));
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\'');
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/add/word", name="addWord", methods={"POST"})
     */
    public function addWord(Request $request) {
        $response = new Response();
        try {
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy($parametersAsArray['word']['category']);
            if (!$category) {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $response->setContent('No category found for id '. $parametersAsArray['word']['category']['id']);
            }
            else {
                $word = new Word();
                $word->setCategory($category);
                $word->setValue($parametersAsArray['word']['value']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($word);
                $em->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($word->toJSON()));
            }

        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/update/word/{idWord}", name="editWord", methods={"PUT","PATCH"})
     * @param $idWord
     * @param Request $request
     * @return Response
     */
    public function editWord( $idWord,Request $request) {
        $response = new Response();
        try {
            $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
            $data =   json_decode($request->getContent(), true);
            $request->request->replace($data);
            if($word != null) {
                $category =  $this->getDoctrine()
                    ->getRepository(Category::class)
                    ->findOneBy(array('id' =>$data['category']['id']));
                if(!$category) {
                    $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                    $response->setContent("category  ".$data['category']['name']." does not exist");
                }
                else {
                    $word->setCategory($category);
                    $word->setValue($data['value']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($word);
                    $em->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent(json_encode([$word->toJSON()]));
                }
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\'');
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/delete/word/{idWord}", name="deleteWord", methods={DELETE})
     */
    public function deleteWord($idWord) {
        $response = new Response();
        try {
            $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
            if($word != null) {
                $wordDeleteValue = $word->getValue();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent('Suppression du mot \'' . $wordDeleteValue . '\' effectuée avec succès');
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\'');
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/report/word/{idWord}", name="reportWord")
     */
    public function reportWord($idWord)
    {
        $response = new Response();
        try {
            $word = $this->getDoctrine()->getRepository(Word::class)->findOneBy(['id' => $idWord]);
            if ($word != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent('Signalemennt du mot \'' . $word->getValue() . '\' effectué avec succès');
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Aucun mot ne correspond à l\'identifiant \'' . $idWord . '\'');
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/get/category", name="getCategory")
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
                $response->setContent(json_encode(  $categories));
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
}