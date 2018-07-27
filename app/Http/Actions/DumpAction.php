<?php
namespace App\Http\Actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Http\Responders\HomeResponder;
use App\Models\HttpRequest;

class DumpAction
{
    /**
     * @var HomeResponder
     */
    private $responder;

    public function __construct(HomeResponder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $data = json_decode(file_get_contents(__DIR__ . '/../../../storage/log'));
        $model = new HttpRequest;
        $model->method = $data->method;
        $model->headers = $data->headers;
        $model->body = $data->body;
        $model->files = $data->files;

        return $this->responder->echo($response, $model);
    }
}
