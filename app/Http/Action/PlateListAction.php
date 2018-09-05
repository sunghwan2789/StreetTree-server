<?php
namespace App\Http\Action;

use App\Http\Responder\PlateResponder;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Repository\MeasureRepository;
use Doctrine\ORM\EntityManager;
use App\Entity\Measure;
use App\Repository\PlateRepository;


class PlateListAction
{
    /**
     * @var PlateResponder
     */
    private $responder;

    /**
     * @var PlateRepository
     */
    private $plates;

    public function __construct(
        PlateResponder $responder,
        PlateRepository $plates
    ) {
        $this->responder = $responder;
        $this->plates = $plates;
    }

    public function __invoke(Request $request, Response $response)
    {
        $idQuery = $request->getQueryParam('q');
        $plates = $this->plates->findByStart($idQuery);
        return $this->responder->collection($response, $plates);
    }
}
