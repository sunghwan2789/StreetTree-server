<?php
namespace App\Http\Action;

use App\Http\Responder\RegionResponder;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Repository\MeasureRepository;
use Doctrine\ORM\EntityManager;
use App\Entity\Measure;
use App\Repository\MeasuresetRepository;


class RegionMeasureSearchAction
{
    /**
     * @var RegionResponder
     */
    private $responder;

    /**
     * @var MeasureRepository
     */
    private $measures;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(
        RegionResponder $responder,
        MeasureRepository $measures,
        MeasuresetRepository $measuresets,
        EntityManager $em
    ) {
        $this->responder = $responder;
        $this->measures = $measures;
        $this->measuresets = $measuresets;
        $this->em = $em;
    }

    public function __invoke($codes, Request $request, Response $response)
    {
        $measures = $this->measures->findByCode(explode('/', $codes));
        return $this->responder->collection($response, $measures);
    }
}
