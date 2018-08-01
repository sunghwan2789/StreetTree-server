<?php
namespace App\Http\Action;

use Doctrine\ORM\EntityManager;
use App\Http\Responder\FileResponder;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Entity\File;
use App\Repository\UserRepository;
use App\Repository\FileRepository;

final class RootImageDownloadAction
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var FileResponder
     */
    private $responder;

    /**
     * @var FileRepository
     */
    private $files;

    public function __construct(
        EntityManager $em,
        FileResponder $responder,
        FileRepository $files
    ) {
        $this->em = $em;
        $this->responder = $responder;
        $this->files = $files;
    }

    public function __invoke($id, Request $request, Response $response)
    {
        $rootImage = $this->files->find($id);
        return $this->responder->download($response, $rootImage);
    }
}
