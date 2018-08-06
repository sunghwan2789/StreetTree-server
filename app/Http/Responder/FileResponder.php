<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\File;
use Slim\Http\Body;
use App\Service\Transformer;
use App\Transformer\FileTransformer;
use Ramsey\Http\Range\Range;
use Ramsey\Http\Range\Exception\NoRangeException;
use Ramsey\Http\Range\Unit\UnitInterface;
use Slim\Http\Stream;
use Ramsey\Http\Range\Unit\UnitRangeInterface;
use GuzzleHttp\Psr7\LimitStream;
use GuzzleHttp\Psr7\LazyOpenStream;
use Psr\Http\Message\StreamInterface;

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
            ->withJson($this->transformer->item($file, new FileTransformer()));
    }

    public function show(Response $response, File $file, ?UnitInterface $rangeUnit)
    {
        return $this->send($response, $file, 'inline', $rangeUnit);
    }

    public function download(Response $response, File $file, ?UnitInterface $rangeUnit)
    {
        return $this->send($rseponse, $file, 'attachment', $rangeUnit);
    }

    private function send(Response $response, File $file, string $dispositionType, ?UnitInterface $rangeUnit)
    {
        set_time_limit(0);

        $filename = $file->originalFilename;
        $unicodeFilename = rawurlencode($file->originalFilename);
        // TODO: settings.fileStoragePath 혹은 filename에 절대경로 포함하기?
        // @see https://github.com/ppy/osu-web/blob/master/app/Traits/Uploadable.php
        $stream = new LazyOpenStream(__DIR__ . '/../../../storage/files/' . $file->filename, 'rb');

        $response = $response->withHeader('Accept-Ranges', 'bytes')
            ->withHeader(
                'Content-Disposition',
                $dispositionType
                . "; filename=\"{$filename}\""
                . "; filename*=UTF-8\'\'{$unicodeFilename}"
            );

        if ($rangeUnit !== null && $rangeUnit->getRangeUnit() === 'bytes') {
            $ranges = $rangeUnit->getRanges();
            if (count($ranges) == 1) {
                return $this->sendRange($response, $file, $stream, $ranges[0]);
            }
        }

        return $this->sendFull($response, $file, $stream);
    }

    private function sendFull(Response $response, File $file, StreamInterface $stream)
    {
        return $response->withStatus(200)
            ->withHeader('Content-Type', $file->mediaType)
            ->withHeader('Content-Length', $file->size)
            ->withBody($stream);
    }

    private function sendRange(Response $response, File $file, StreamInterface $stream, UnitRangeInterface $range)
    {
        return $response->withStatus(206)
            ->withHeader('Content-Type', $file->mediaType)
            ->withHeader('Content-Length', $range->getLength())
            ->withHeader(
                'Content-Range',
                'bytes ' . $range->getStart() . '-' . $range->getEnd() . '/' . $range->getTotalSize()
            )
            ->withBody(new LimitStream($stream, $range->getLength(), $range->getStart()));
    }
}
