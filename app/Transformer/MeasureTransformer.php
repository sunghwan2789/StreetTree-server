<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Entity\Measure;

class MeasureTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'measureset',
    ];

    protected $defaultIncludes = [
        'rootImage',
    ];

    public function transform(Measure $measure)
    {
        return [
            'measure_id'     => $measure->id,
            'sequenceNumber' => $measure->sequenceNumber,
            'coordinate' => [
                'latitude'   => $measure->latitude,
                'longitude'  => $measure->longitude,
            ],
            'region' => [
                'sidoCode'   => $measure->sidoCode,
                'goonCode'   => $measure->goonCode,
                'guCode'     => $measure->guCode,
            ],
            'plateName'      => $measure->plateName,
            'treeNumber'     => $measure->treeNumber,
            'isInstalled'    => $measure->isInstalled,
            'points'         => $measure->points,
        ];
    }

    public function includeRootImage(Measure $measure)
    {
        // FIXME: NULL이면 필드가 생략되는 문제
        return $measure->rootImage
            ? $this->item($measure->rootImage, new FileTransformer)
            : $this->null();
    }
}
