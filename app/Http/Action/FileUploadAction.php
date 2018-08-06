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
use Psr\Container\ContainerInterface;
use function GuzzleHttp\Psr7\hash;

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
        ContainerInterface $container
    ) {
        $this->em = $em;
        $this->responder = $responder;
        $this->users = $users;
        $this->fileStorage = $container->get('settings.fileStoragePath');

        set_time_limit(0);
    }

    public function getUploadedFile(Request $request): UploadedFile
    {
        return $request->getUploadedFiles()['file'];
    }

    public function __invoke(Request $request, Response $response)
    {
        $uploadedFile = $this->getUploadedFile($request);
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            throw new \Exception('failed to upload');
        }

        $stream = $uploadedFile->getStream();

        $checksum_crc32   = hash($stream, 'crc32b');
        $size             = $uploadedFile->getSize();
        $mediaType        = $uploadedFile->getClientMediaType();
        $originalFilename = $uploadedFile->getClientFilename();
        $extension        = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $filename         = Uuid::uuid4()->toString() . '.' . $extension;

        $stream->close();

        $uploadedFile->moveTo($this->fileStorage . '/' . $filename);

        $userId = $request->getAttribute(getenv('JWTAUTH_NAME'))['i'];
        $user = $this->users->find($userId);

        $file = new File();
        $file->checksum_crc32   = $checksum_crc32;
        $file->createdAt        = new \DateTime();
        $file->size             = $size;
        $file->mediaType        = $mediaType;
        $file->originalFilename = $originalFilename;
        $file->filename         = $filename;
        $file->owner            = $user;
        $this->em->persist($file);
        $this->em->flush();

        return $this->responder->success($response, $file);
    }
}
