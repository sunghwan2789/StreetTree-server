<?php
namespace App\Http\Action;

use Doctrine\ORM\EntityManager;
use App\Http\Responder\RootImageResponder;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Entity\RootImage;
use App\Repository\UserRepository;
use App\Repository\RootImageRepository;

final class RootImageDownloadAction
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var RootImageResponder
     */
    private $responder;

    /**
     * @var RootImageRepository
     */
    private $rootImages;

    public function __construct(
        EntityManager $em,
        RootImageResponder $responder,
        RootImageRepository $rootImages
    ) {
        $this->em = $em;
        $this->responder = $responder;
        $this->rootImages = $rootImages;
    }

    public function __invoke($id, Request $request, Response $response)
    {
        $rootImage = $this->rootImages->find($id);
        return $this->responder->download($response, $rootImage);
    }
}
