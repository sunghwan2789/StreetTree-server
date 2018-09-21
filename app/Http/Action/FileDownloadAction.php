<?php
namespace App\Http\Action;

use Doctrine\ORM\EntityManager;
use App\Http\Responder\FileResponder;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Entity\File;
use App\Repository\UserRepository;
use App\Repository\FileRepository;
use App\Repository\MeasureRepository;
use Ramsey\Http\Range\Range;
use Ramsey\Http\Range\Exception\NoRangeException;
use Ramsey\Http\Range\Exception\HttpRangeException;

final class FileDownloadAction
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var FileResponder
     */
    private $responder;

    /**
     * @var FileRepository
     */
    private $files;

    public function __construct(
        EntityManager $em,
        FileResponder $responder,
        FileRepository $files
    ) {
        $this->em = $em;
        $this->responder = $responder;
        $this->files = $files;
    }

    public function __invoke($file_id, Request $request, Response $response)
    {
        $file = $this->files->find($file_id);
        $rangeUnit = null;
        if ($request->hasHeader('Range')) {
            try {
                $rangeRequest = new Range($request, $file->size);
                $rangeUnit = $rangeRequest->getUnit();
            } catch (HttpRangeException $e) {}
        }
        return $this->responder->download($response, $file, $rangeUnit);
    }
}
