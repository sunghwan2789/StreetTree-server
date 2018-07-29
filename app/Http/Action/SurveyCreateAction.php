<?php
namespace App\Http\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\ORM\EntityManager;
use App\Entity\MeasureMetadata;
use App\Entity\Measure;
use App\Entity\User;
use App\Repository\UserRepository;

class SurveyCreateAction
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var UserRepository
     */
    private $user;

    public function __construct(
        EntityManager $em,
        UserRepository $user
    ) {
        $this->em = $em;
        $this->user = $user;
    }

    public function __invoke(Request $request, Response $response)
    {
        $body = json_decode($request->getParsedBody()['str']);

        $this->em->beginTransaction();

        $userId = $request->getAttribute(getenv('JWTAUTH_NAME'))['i'];
        // FIXME: 로그인 기능이 정상 작동하면 $userId는 null일 수 없다!!!!
        $user = $this->user->find($userId ?? 0);

        $metadata = new MeasureMetadata();
        // $metadata->siteRegionCode = $body->region_code;
        $metadata->siteName = $body->field_name;
        $metadata->clientName = $body->client;
        $metadata->createdAt = new \DateTime($body->date);
        $metadata->author = $user;
        // FIXME: 로그인 기능이 정상 작동하면  $user도 null일 수 없다!!!!
        $metadata->authorFullName = $user->fullName ?? '익명';
        $this->em->persist($metadata);
        $this->em->flush();

        foreach ($body->list as $data) {
            $measure = new Measure();
            $measure->sequenceNumber = $data->number;
            $measure->latitude = $data->latitude;
            $measure->longitude = $data->longitude;
            $measure->plateName = $data->plate;
            $measure->treeNumber = $data->tree_number;
            $measure->isInstalled = $data->is_installed;
            $measure->points = $data->points;
            // $measure->picture
            $measure->metadata = $metadata;

            $this->em->persist($measure);
        }
        $this->em->flush();

        $this->em->commit();

        return $response->withStatus(201);
    }
}
