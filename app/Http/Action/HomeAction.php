<?php
namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface;
use App\Http\Responder\HomeResponder;
use App\Model\HttpRequest;
use App\Service\DumpService;

class HomeAction
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

    public function __invoke(Request $request, Response $response)
    {
        $model = new HttpRequest;
        $model->method = $request->getMethod()
            . ' ' . json_encode($request->getQueryParams())
            . ' HTTP/' . $request->getProtocolVersion();
        foreach ($request->getHeaders() as $name => $value) {
            $model->headers[] = $name . ': ' . implode(',', $value);
        }
        $model->body = json_encode($request->getParsedBody(), JSON_PRETTY_PRINT);
        $model->files = json_encode($request->getUploadedFiles(), JSON_PRETTY_PRINT);
        $this->dump->save($model);

        return $this->responder->echo($response, $model);
    }
}
