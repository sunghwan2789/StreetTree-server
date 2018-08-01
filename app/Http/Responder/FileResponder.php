<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\File;
use Slim\Http\Body;

final class FileResponder
{
    public function success(Response $response, File $file)
    {
        return $response->withStatus(201)
            ->withJson([
                'id' => $file->id,
            ]);
    }

    public function view(Response $response, File $file)
    {
        return $this->send($response, $file, 'inline');
    }

    public function download(Response $response, File $file)
    {
        return $this->send($rseponse, $file, 'attachment');
    }

    private function send(Response $response, File $file, string $dispositionType)
    {
        $asciiFilename = $file->filename ?? $file->id . '.' . $file->extension;
        $unicodeFilename = rawurlencode($asciiFilename);
        // TODO: 206 상태 코드 지원하기
        return $response->withStatus(200)
            ->withHeader('Content-Type', $file->mimeType)
            ->withHeader('Content-Disposition', $dispositionType
                . "; filename=\"$asciiFilename\""
                . "; filename*=UTF-8\'\'$unicodeFilename")
            ->withHeader('Content-Length', $file->size)
            ->withBody(new Body($file->data));
    }
}
