<?php
namespace App\Http\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\ORM\EntityManager;
use App\Entity\Measureset;
use App\Entity\Measure;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\FileRepository;
use App\Http\Responder\MeasureResponder;

class MeasureCreateAction
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var MeasureResponder
     */
    private $responder;

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
        MeasureResponder $responder,
        UserRepository $users,
        FileRepository $files
    ) {
        $this->em = $em;
        $this->responder = $responder;
        $this->users = $users;
        $this->files = $files;
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->em->beginTransaction();

        $userId = $request->getAttribute(getenv('JWTAUTH_NAME'))['i'];
        $user = $this->users->find($userId);

        $measureset = new Measureset();
        $measureset->siteName = $request->getParsedBodyParam('siteName');
        $measureset->clientName = $request->getParsedBodyParam('clientName');
        $measureset->createdAt = new \DateTime($request->getParsedBodyParam('createdAt'));
        $measureset->author = $user;
        $measureset->authorFullName = $user->fullName;
        $this->em->persist($measureset);
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
            $measure->sidoCode = $item['sido'];
            $measure->goonCode = $item['goon'];
            $measure->guCode = $item['gu'];
            $measure->plateName = $item['plateName'];
            $measure->treeNumber = $item['treeNumber'];
            $measure->isInstalled = $item['isInstalled'];
            $measure->points = $item['points'];
            $measure->rootImage = $rootImage;
            $measure->measureset = $measureset;
            $measureset->measures[] = $measure;

            $this->em->persist($measure);
        }
        $this->em->flush();

        $this->em->commit();

        return $this->responder->success($response, $measureset);
    }
}
