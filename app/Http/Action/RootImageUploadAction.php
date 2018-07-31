<?php
namespace App\Http\Action;

use Doctrine\ORM\EntityManager;
use App\Http\Responder\RootImageResponder;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Entity\RootImage;
use App\Repository\UserRepository;

final class RootImageUploadAction
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
     * @var UserRepository
     */
    private $users;

    public function __construct(
        EntityManager $em,
        RootImageResponder $responder,
        UserRepository $users
    ) {
        $this->em = $em;
        $this->responder = $responder;
        $this->users = $users;
    }

    public function __invoke(Request $request, Response $response)
    {
        $body = $request->getBody();
        $data = $body->getContents();

        $authorId = $request->getAttribute(getenv('JWTAUTH_NAME'))['i'];
        $author = $this->users->find($authorId);

        $rootImage = new RootImage();
        $rootImage->author = $author;
        $rootImage->hash_crc32 = hash('crc32b', $data);
        $rootImage->size = strlen($data);
        $rootImage->data = $data;
        $rootImage->createdAt = new \DateTime();
        $this->em->persist($rootImage);
        $this->em->flush();

        return $this->responder->success($response, $rootImage);
    }
}
