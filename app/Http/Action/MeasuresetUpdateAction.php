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
use App\Repository\MeasuresetRepository;
use App\Repository\MeasureRepository;
use Slim\Route;

class MeasuresetUpdateAction
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

    /**
     * @var MeasuresetRepository
     */
    private $measuresets;

    /**
     * @var MeasureRepository
     */
    private $measures;

    public function __construct(
        EntityManager $em,
        MeasuresetResponder $responder,
        UserRepository $users,
        FileRepository $files,
        MeasuresetRepository $measuresets,
        MeasureRepository $measures
    ) {
        $this->em = $em;
        $this->responder = $responder;
        $this->users = $users;
        $this->files = $files;
        $this->measuresets = $measuresets;
        $this->measures = $measures;
    }

    public function __invoke(Request $request, Response $response, Route $route)
    {
        $this->em->beginTransaction();

        $userId = $request->getAttribute(getenv('JWTAUTH_NAME'))['i'];
        $user   = $this->users->find($userId);

        $measureset = $this->measuresets->find($route->getArgument('measureset_id'));
        $measureset->siteName       = $request->getParsedBodyParam('siteName');
        $measureset->clientName     = $request->getParsedBodyParam('clientName');
        $measureset->createdAt      = new \DateTime($request->getParsedBodyParam('createdAt'));
        $measureset->author         = $user;
        $measureset->salespersonName = $request->getParsedBodyParam('salespersonName') ?: '';
        $measureset->deliveryTarget  = $request->getParsedBodyParam('deliveryTarget') ?: '';
        $measureset->deliveryDate    = new \DateTime($request->getParsedBodyParam('deliveryDate'));
        $measureset->differenceValue = intval($request->getParsedBodyParam('differenceValue'));
        $this->em->flush();

        $newMeasures = [];
        foreach ($request->getParsedBodyParam('list') as $item) {
            $measure = $this->measures->find($item['measure_id']);

            $rootImage = null;
            // FIXME: Undefined index after Gson serialization
            if ($item['rootImageId'] !== null) {
                // FIXME: [ "id" => 1 ] 등으로도 질의 가능
                $rootImage = $this->files->find($item['rootImageId']);
            }
            // 수목 뿌리 사진 갱신 안하면 기존 사진 사용
            if ($rootImage === null) {
                $rootImage = $measure->rootImage;
            }

            if ($measure === null) {
                $measure = new Measure();
            }
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
            $newMeasures[] = $measure;

            $this->em->persist($measure);
        }

        $newMeasureIds = array_map(function (Measure $measure) { return $measure->id; }, $newMeasures);
        $obsoletedMeasures = array_filter($measureset->measures, function (Measure $measure) use ($newMeasuresIds) {
            return !in_array($measure->id, $newMeasuresIds);
        });
        foreach ($obsoletedMeasures as $measure) {
            $this->em->remove($measure);
        }
        $measureset->measures = $newMeasures;
        $this->em->flush();

        $this->em->commit();

        return $this->responder->success($response, $measureset);
    }
}
