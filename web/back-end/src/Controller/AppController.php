<?php

namespace App\Controller;

use App\Service\ExportService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController {
    /**
     * @Route("/export", name="exportLefff", methods={"GET"})
     */
    public function exportLefff() {
        $response = new Response();
        try {
            $service = new ExportService();
            $folderPath = __DIR__.'/';
            $exportFile = "export-result.txt";
            $fileContent = $service->export();

            /* RENVOI DU FICHIER EXISTANT */
            /*$response = new BinaryFileResponse($folderPath.$exportFile);
            $response->headers->set('Content-Type', 'text/plain');

            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                $exportFile
            );
            $response->deleteFileAfterSend();*/

            // CREATION DU FICHIER A LA VOLEE
            $response->setContent($fileContent);
            $disposition = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                $exportFile
            );
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-Type', 'text/plain');

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