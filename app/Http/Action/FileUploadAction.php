<?php
namespace App\Http\Action;

use Doctrine\ORM\EntityManager;
use App\Http\Responder\FileResponder;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Entity\File;
use App\Repository\UserRepository;
use Slim\Http\UploadedFile;
use Ramsey\Uuid\Uuid;
use Slim\Container;

final class FileUploadAction
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
     * @var UserRepository
     */
    private $users;

    /**
     * @var string
     */
    private $fileStorage;

    public function __construct(
        EntityManager $em,
        FileResponder $responder,
        UserRepository $users,
        Container $container
    ) {
        $this->em = $em;
        $this->responder = $responder;
        $this->users = $users;
        $this->fileStorage = __DIR__ . '/../../../storage/files';

        ini_set('max_execution_time', 0);
    }

    public function getUploadedFile($request): UploadedFile
    {
        return $request->getUploadedFiles()['file'];
    }

    public function __invoke(Request $request, Response $response)
    {
        $filename = Uuid::uuid4()->toString();

        $uploadedFile = $this->getUploadedFile($request);
        $uploadedFile->moveTo($this->fileStorage . '/' . $filename);

        $checksum_crc32   = hash_file('crc32b', $this->fileStorage . '/' . $filename);
        $size             = $uploadedFile->getSize();
        $mediaType        = $uploadedFile->getClientMediaType();
        $originalFilename = $uploadedFile->getClientFilename();


        $userId = $request->getAttribute(getenv('JWTAUTH_NAME'))['i'];
        $user = $this->users->find($userId);

        $rootImage = new File();
        $rootImage->checksum_crc32   = $checksum_crc32;
        $rootImage->createdAt        = new \DateTime();
        $rootImage->size             = $size;
        $rootImage->mediaType        = $mediaType;
        $rootImage->originalFilename = $originalFilename;
        $rootImage->filename         = $filename;
        $rootImage->owner            = $user;
        $this->em->persist($rootImage);
        $this->em->flush();

        return $this->responder->success($response, $rootImage);
    }
}
