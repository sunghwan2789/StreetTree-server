<?php
namespace App\Http\Action;

use App\Repository\MeasuresetRepository;
use App\Http\Responder\MeasuresetResponder;
use Slim\Http\Request;
use Slim\Http\Response;

final class MeasuresetShowAction
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

    public function __invoke($measureset_id, Request $request, Response $response)
    {
        $measureset = $this->measuresets->find($measureset_id);

        return $this->responder->show($response, $measureset);
    }
}
