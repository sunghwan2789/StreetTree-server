<?php
namespace App\Http\Actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Http\Responders\HomeResponder;
use App\Models\HttpRequest;
use App\Services\DumpService;

class DumpAction
{
    /**
     * @var HomeResponder
     */
    private $responder;

    /**
     * @var DumpService
     */
    private $dump;

    public function __construct(
        HomeResponder $responder,
        DumpService $dump
    ) {
        $this->responder = $responder;
        $this->dump = $dump;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $data = $this->dump->load();
        $model = new HttpRequest;
        $model->method = $data->method;
        $model->headers = $data->headers;
        $model->body = $data->body;
        $model->files = $data->files;

        return $this->responder->echo($response, $model);
    }
}
