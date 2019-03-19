<?php

namespace App\Controller;

use App\Service\ExportService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController {
    /**
     * @Route("/export/{type}", name="exportLefff", methods={"GET"})
     */
    public function exportLefff($type) {
        $response = new Response();
        try {
            $service = new ExportService();
            $success = false;
            $folderPath = __DIR__.'/';
            $exportFile = "export-result.";
            $extension = "";
            $fileContent = "";
            $contentType = "";
            switch ($type) {
                case 'json':
                    $success = true;
                    $contentType = "application/json";
                    $extension = "json";
                    $fileContent = $service->exportJSON();
                    break;
                case 'xml':
                    $success = true;
                    $contentType = "application/xml";
                    $extension = "xml";
                    $fileContent = $service->exportXML();
                    break;
                default:
                    $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                    $response->setContent("Invalid export format type.");
                    break;

            }
            if ($success) {
                /* RENVOI DU FICHIER EXISTANT */
                /*$response = new BinaryFileResponse($folderPath.$exportFile.$extension);
                $response->headers->set('Content-Type', $contentType);

                $response->setContentDisposition(
                    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                    $exportFile.$extension
                );
                $response->deleteFileAfterSend();*/

                // CREATION DU FICHIER A LA VOLEE
                $response->setContent($fileContent);
                $disposition = $response->headers->makeDisposition(
                    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                    $exportFile.$extension
                );
                $response->headers->set('Content-Disposition', $disposition);
                $response->headers->set('Content-Type', $contentType);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/import", name="importLefff", methods={"POST"})
     */
    public function importLefff(Request $request) {
        $response = new Response();
        try {
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent(null);
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}