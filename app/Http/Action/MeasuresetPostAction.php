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
use App\Http\Responder\MeasuresetResponder;

class MeasuresetPostAction
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var MeasuresetResponder
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
        MeasuresetResponder $responder,
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
        $user   = $this->users->find($userId);

        $measureset = new Measureset();
        $measureset->siteName       = $request->getParsedBodyParam('siteName');
        $measureset->clientName     = $request->getParsedBodyParam('clientName');
        $measureset->createdAt      = new \DateTime($request->getParsedBodyParam('createdAt'));
        $measureset->author         = $user;
        $measureset->salespersonName = $request->getParsedBodyParam('salespersonName');
        $measureset->deliveryTarget  = $request->getParsedBodyParam('deliveryTarget');
        $measureset->deliveryDate    = new \DateTime($request->getParsedBodyParam('deliveryDate'));
        $measureset->differenceValue = intval($request->getParsedBodyParam('differenceValue'));
        $this->em->persist($measureset);
        $this->em->flush();

        foreach ($request->getParsedBodyParam('list') as $item) {
            $rootImage = null;
            // FIXME: Undefined index after Gson serialization
            if ($item['rootImageId'] !== null) {
                // FIXME: [ "id" => 1 ] 등으로도 질의 가능
                $rootImage = $this->files->find($item['rootImageId']);
            }

            $measure = new Measure();
            $measure->sequenceNumber = $item['sequenceNumber'];
            $measure->latitude       = $item['latitude'];
            $measure->longitude      = $item['longitude'];
            $measure->siCode         = $item['sido'];
            $measure->guCode         = $item['goon'];
            $measure->dongCode       = $item['gu'];
            $measure->plateName      = $item['plateName'];
            $measure->treeNumber     = $item['treeNumber'];
            $measure->isInstalled    = $item['isInstalled'];
            $measure->points         = $item['points'];
            $measure->treeLocation   = $item['treeLocation'];
            $measure->memo           = $item['memo'];
            $measure->rootImage      = $rootImage;
            $measure->measureset     = $measureset;
            $measureset->measures[] = $measure;

            $this->em->persist($measure);
        }
        $this->em->flush();

        $this->em->commit();

        return $this->responder->success($response, $measureset);
    }
}
