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

final class RootImageDownloadAction
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

    /**
     * @var MeasureRepository
     */
    private $measures;

    public function __construct(
        EntityManager $em,
        FileResponder $responder,
        FileRepository $files,
        MeasureRepository $measures
    ) {
        $this->em = $em;
        $this->responder = $responder;
        $this->files = $files;
        $this->measures = $measures;
    }

    public function __invoke($measure_id, Request $request, Response $response)
    {
        $rootImage = $this->measures->find($measure_id)->rootImage;
        if ($request->hasHeader('Range')) {
            try {
                $rangeRequest = new Range($request, $rootImage->size);
                $rangeUnit = $rangeRequest->getUnit();
                return $this->responder->show($response, $rootImage, $rangeUnit);
            } catch (NoRangeException $e) {}
        }
        return $this->responder->show($response, $rootImage, null);
    }
}
