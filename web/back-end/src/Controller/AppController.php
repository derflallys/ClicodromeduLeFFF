<?php

namespace App\Controller;

use App\Entity\Word;
use App\Service\ExportService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur utilisé pour les fonctionnalités d'import/export du lexique
 * @package App\Controller
 */
class AppController extends AbstractController {
    /**
     * Route d'export du lexique
     * @Route("/export", name="exportLefff", methods={"GET"})
     * @return Response
     */
    public function exportLefff() {
        $response = new Response();
        try {
            $allWords = $this->getDoctrine()->getRepository(Word::class)->findBy([], ['value' => 'ASC']);
            // Si des mots sont enregistrés en base de données
            if($allWords != null) {
                $service = new ExportService();
                $exportFile = "export-result.txt";
                $fileContent = $service->export($allWords);

                // CREATION DU FICHIER A LA VOLEE
                $response->setContent($fileContent);
                $disposition = $response->headers->makeDisposition(
                    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                    $exportFile
                );
                $response->headers->set('Content-Disposition', $disposition);
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent("Aucun mot n'est enregistré en base de données.");
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent($e->getMessage());
        }
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }

    /**
     * Route utilisée pour importer un lexique
     * @Route("/import/{type}", name="importLefff", methods={"POST"})
     * @param $type (type d'import)
     * @param Request $request
     * @return Response
     */
    public function importLefff($type, Request $request) {
        $response = new Response();
        try {
            $service = new ExportService();
            $fileContent = $request->getContent();
            $tmp = explode("Content-Type: ", $fileContent)[1];
            $contentType = explode("\r\n\r\n", $tmp)[0];

            // Si le format du fichier envoyé ne correspond pas
            if ($contentType != "text/plain" && $contentType != "application/octet-stream") {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                $response->setContent("Invalid Content-type. Required 'text/plain' or 'application/octet-stream'.");
                return $response;
            }
            $success = false;
            // L'import peut être long -> on désactive le temps d'execution max de PHP
            set_time_limit(0);
            $fileContent = $service->filteringContent($fileContent);
            $service->truncateDatabase($this->getDoctrine());
            // Selon le type, on execute l'import correspondant
            switch ($type) {
                case "custom":
                    $service->importCustom($this->getDoctrine(), $fileContent);
                    $success = true;
                    break;
                case "txt":
                    $service->importTxt($this->getDoctrine(), $fileContent);
                    $success = true;
                    break;
                case "mlex":
                    $service->importMlex($this->getDoctrine(), $fileContent);
                    $success = true;
                    break;
                default:
                    $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                    $response->setContent("Type d'import invalide.");
                    break;
            }
            if($success) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}