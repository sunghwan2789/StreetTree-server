<?php
namespace App\Http\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\ORM\EntityManager;
use App\Entity\MeasureMetadata;
use App\Entity\Measure;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\FileRepository;

class MeasureCreateAction
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var FileRepository
     */
    private $files;

    public function __construct(
        EntityManager $em,
        UserRepository $users,
        FileRepository $files
    ) {
        $this->em = $em;
        $this->users = $users;
        $this->files = $files;
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->em->beginTransaction();

        $userId = $request->getAttribute(getenv('JWTAUTH_NAME'))['i'];
        $user = $this->users->find($userId);

        $metadata = new MeasureMetadata();
        // TODO: 앱에서 전송 안 해서 미구현
        // $metadata->siteRegionCode = $request->getParsedBodyParam('siteRegionCode');
        $metadata->siteName = $request->getParsedBodyParam('siteName');
        $metadata->clientName = $request->getParsedBodyParam('clientName');
        $metadata->createdAt = new \DateTime($request->getParsedBodyParam('createdAt'));
        $metadata->author = $user;
        $metadata->authorFullName = $user->fullName;
        $this->em->persist($metadata);
        $this->em->flush();

        foreach ($request->getParsedBodyParam('list') as $item) {
            $rootImage = null;
            if (!empty($item['rootImageId'])) {
                $rootImage = $this->files->find($item['rootImageId']);
            }

            $measure = new Measure();
            $measure->sequenceNumber = $item['sequenceNumber'];
            $measure->latitude = $item['latitude'];
            $measure->longitude = $item['longitude'];
            $measure->plateName = $item['plateName'];
            $measure->treeNumber = $item['treeNumber'];
            $measure->isInstalled = $item['isInstalled'];
            $measure->points = $item['points'];
            $measure->rootImage = $rootImage;
            $measure->metadata = $metadata;

            $this->em->persist($measure);
        }
        $this->em->flush();

        $this->em->commit();

        return $response->withStatus(201)
            ->withJson([
                'id' => $metadata->id,
            ]);
    }
}
