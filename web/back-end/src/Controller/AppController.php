<?php

namespace App\Controller;

use App\Entity\Word;
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
     * @Route("/export", name="exportLefff", methods={"GET"})
     */
    public function exportLefff() {
        $response = new Response();
        try {
            $allWords = $this->getDoctrine()->getRepository(Word::class)->findBy([], ['value' => 'ASC']);
            if($allWords != null) {
                $service = new ExportService();
                $exportFile = "export-result.txt";
                $fileContent = $service->export($allWords);

                /* RENVOI DU FICHIER EXISTANT */
                /*$folderPath = __DIR__ . '/';
                $response = new BinaryFileResponse($folderPath . $exportFile);
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
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent("No words register in database.");
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent($e->getMessage());
        }
        $response->headers->set('Content-Type', 'text/plain');
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