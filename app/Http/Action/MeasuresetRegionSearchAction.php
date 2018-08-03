<?php
namespace App\Http\Action;

use App\Http\Responder\MeasuresetResponder;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Repository\MeasureRepository;
use Doctrine\ORM\EntityManager;
use App\Entity\Measure;
use App\Repository\MeasuresetRepository;


class MeasuresetRegionSearchAction
{
    /**
     * @var MeasuresetResponder
     */
    private $responder;

    /**
     * @var MeasuresetRepository
     */
    private $measuresets;

    public function __construct(
        MeasuresetResponder $responder,
        MeasuresetRepository $measuresets
    ) {
        $this->responder = $responder;
        $this->measuresets = $measuresets;
    }

    public function __invoke($codes, Request $request, Response $response)
    {
        $measuresets = $this->measuresets->findByCode(...explode('/', $codes));
        return $this->responder->collection($response, $measuresets);
    }
}
