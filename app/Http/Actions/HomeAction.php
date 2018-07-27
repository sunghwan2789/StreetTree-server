<?php
namespace App\Http\Actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Http\Responders\HomeResponder;
use App\Models\HttpRequest;

class HomeAction
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
        $model = new HttpRequest;
        $model->method = $request->getMethod()
            . ' ' . json_encode($request->getQueryParams())
            . ' HTTP/' . $request->getProtocolVersion();
        foreach ($request->getHeaders() as $name => $value) {
            $model->headers[] = $name . ': ' . implode(',', $value);
        }
        $model->body = $request->getParsedBody();
        file_put_contents(__DIR__ . '/../../../storage/log', json_encode($model, JSON_PRETTY_PRINT));

        return $this->responder->echo($response, $model);
    }
}
