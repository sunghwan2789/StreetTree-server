<?php
namespace App\Http\Action;

use App\Http\Responder\RegionResponder;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Repository\MeasureRepository;
use Doctrine\ORM\EntityManager;
use App\Entity\Measure;
use App\Repository\MeasuresetRepository;


class MeasuresetSearchAction
{
    /**
     * @var RegionResponder
     */
    private $responder;

    /**
     * @var MeasuresetRepository
     */
    private $measuresets;

    public function __construct(
        RegionResponder $responder,
        MeasuresetRepository $measuresets
    ) {
        $this->responder = $responder;
        $this->measuresets = $measuresets;
    }

    public function __invoke(Request $request, Response $response)
    {
        $siteNameQuery = $request->getParsedBodyParam('q');
        $measuresets = $this->measuresets->findBySiteName($siteNameQuery);
        return $this->responder->collection($response, $measuresets);
    }
}
