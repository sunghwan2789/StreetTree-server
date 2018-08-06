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
use Ramsey\Http\Range\Exception\NotSatisfiableException;
use Ramsey\Http\Range\Exception\ParseException;
use Psr\Container\ContainerInterface;
use Ramsey\Http\Range\Exception\HttpRangeException;

final class FileResponder
{
    /**
     * @var Transformer
     */
    private $transformer;

    private $fileStorage;

    public function __construct(Transformer $transformer, ContainerInterface $container)
    {
        $this->transformer = $transformer;
        $this->fileStorage = $container->get('settings.fileStoragePath');
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
        $stream = new LazyOpenStream($this->fileStorage . '/' . $file->filename, 'rb');

        $fileResponse = $response->withHeader('Accept-Ranges', 'bytes')
            ->withHeader('Content-Type', $file->mediaType)
            ->withHeader(
                'Content-Disposition',
                $dispositionType
                . "; filename=\"{$filename}\""
                . "; filename*=UTF-8\'\'{$unicodeFilename}"
            );

        if ($rangeUnit !== null && $rangeUnit->getRangeUnit() === 'bytes') {
            try {
                $ranges = $rangeUnit->getRanges();
                // 처리 가능한 Range request만 처리하고
                // 나머지는 무시하여 파일 전체 데이터 전송
                if (count($ranges) == 1) {
                    return $this->sendRange($fileResponse, $stream, $ranges[0]);
                }
            } catch (NotSatisfiableException | ParseException $e) {
                return $response->withStatus(416);
            } catch (HttpRangeException $e) {}
        }

        return $this->sendFull($fileResponse, $stream, $file->size);
    }

    private function sendFull(Response $response, StreamInterface $stream, $size)
    {
        return $response->withStatus(200)
            ->withHeader('Content-Length', $size)
            ->withBody($stream);
    }

    private function sendRange(Response $response, StreamInterface $stream, UnitRangeInterface $range)
    {
        return $response->withStatus(206)
            ->withHeader('Content-Length', $range->getLength())
            ->withHeader(
                'Content-Range',
                'bytes ' . $range->getStart() . '-' . $range->getEnd() . '/' . $range->getTotalSize()
            )
            ->withBody(new LimitStream($stream, $range->getLength(), $range->getStart()));
    }
}
