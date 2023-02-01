<?php

namespace App\Controller;

use App\Entity\Resource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mime\FileinfoMimeTypeGuesser;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ResourceController extends AbstractController
{
    #[Route('/fichier/{id}', name: 'file_download', methods: ['GET', 'POST'])]
    public function downloadResourceFile(Resource $resource, UploaderHelper $uploaderHelper)
    {
        if (!$resource->isFile()) throw new NotFoundHttpException();

        $path = $this->getParameter('kernel.project_dir') . $uploaderHelper->asset($resource, 'file');

        $response = new BinaryFileResponse($path);

        $mimeTypeGuesser = new FileinfoMimeTypeGuesser();

        if($mimeTypeGuesser->isGuesserSupported()){
            $response->headers->set('Content-Type', $mimeTypeGuesser->guessMimeType($path));
        }else{
            $response->headers->set('Content-Type', 'text/plain');
        }

        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $resource->getOriginalName()
        );

        return $response;
    }
}