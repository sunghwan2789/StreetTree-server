<?php
namespace App\Http\Action;

use Doctrine\ORM\EntityManager;
use App\Http\Responder\RootImageResponder;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Entity\File;
use App\Repository\UserRepository;

final class FileUploadAction
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
        $mimeInfo = new \finfo(FILEINFO_MIME_TYPE);
        $extInfo = new \finfo(FILEINFO_EXTENSION);

        $userId = $request->getAttribute(getenv('JWTAUTH_NAME'))['i'];
        $user = $this->users->find($userId);

        $rootImage = new File();
        $rootImage->hash_crc32 = hash('crc32b', $data);
        $rootImage->createdAt = new \DateTime();
        $rootImage->size = strlen($data);
        $rootImage->mimeType = $mimeInfo->buffer($data);
        $rootImage->extension = $extInfo->buffer($data);
        $rootImage->data = $data;
        $rootImage->owner = $user;
        $this->em->persist($rootImage);
        $this->em->flush();

        return $this->responder->success($response, $rootImage);
    }
}
