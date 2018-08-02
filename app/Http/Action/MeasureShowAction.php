<?php
namespace App\Http\Action;

use App\Repository\MeasuresetRepository;
use App\Http\Responder\MeasureResponder;
use Slim\Http\Request;
use Slim\Http\Response;

final class MeasureShowAction
{
    /**
     * @var MeasureResponder
     */
    private $responder;

    /**
     * @var MeasuresetRepository
     */
    private $measures;

    public function __construct(
        MeasureResponder $responder,
        MeasuresetRepository $measures
    ) {
        $this->responder = $responder;
        $this->measures = $measures;
    }

    public function __invoke($meta_id, Request $request, Response $response)
    {
        $measureSet = $this->measures->find($meta_id);

        return $this->responder->show($response, $measureSet);
    }
}
