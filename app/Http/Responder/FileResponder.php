<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\File;
use Slim\Http\Body;
use App\Service\Transformer;
use App\Transformer\FileTransformer;

final class FileResponder
{
    /**
     * @var Transformer
     */
    private $transformer;

    public function __construct(Transformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function success(Response $response, File $file)
    {
        return $response->withStatus(201)
            ->withJson($this->transformer->item($file, new FileTransformer));
    }

    public function show(Response $response, File $file)
    {
        return $this->send($response, $file, 'inline');
    }

    public function download(Response $response, File $file)
    {
        return $this->send($rseponse, $file, 'attachment');
    }

    private function send(Response $response, File $file, string $dispositionType)
    {
        $filename = $file->originalFilename;
        $unicodeFilename = rawurlencode($file->originalFilename);
        // TODO: 206 상태 코드 지원하기
        return $response->withStatus(200)
            ->withHeader('Content-Type', $file->mediaType)
            ->withHeader('Content-Disposition', $dispositionType
                . "; filename=\"$filename\""
                . "; filename*=UTF-8\'\'$unicodeFilename")
            ->withHeader('Content-Length', $file->size)
            // TODO: settings.fileStoragePath 혹은 filename에 절대경로 포함하기?
            // @see https://github.com/ppy/osu-web/blob/master/app/Traits/Uploadable.php
            ->withBody(new Body(fopen(__DIR__ . '/../../../storage/files/' . $file->filename, 'rb')));
    }
}
