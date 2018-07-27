<?php
namespace App\Http\Actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface;
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
        $model->body = json_encode($request->getParsedBody(), JSON_PRETTY_PRINT);
        foreach ($request->getUploadedFiles() as $file) {
            $model->files[] = $file->getClientFilename() . ' ... ' . $file->getSize();
        }
        file_put_contents(__DIR__ . '/../../../storage/log', json_encode($model));

        return $this->responder->echo($response, $model);
    }
}
