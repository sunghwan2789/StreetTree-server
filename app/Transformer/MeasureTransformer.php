<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Entity\Measure;
use Slim\Router;

class MeasureTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'measureset',
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
                'siCode'     => $measure->siCode,
                'guCode'     => $measure->guCode,
                'dongCode'   => $measure->dongCode,
            ],
            'plateName'      => $measure->plateName,
            'treeNumber'     => $measure->treeNumber,
            'isInstalled'    => $measure->isInstalled,
            'points'         => $measure->points,
            'rootImageUrl'   => $measure->rootImage !== null
                ? '/measure/'.$measure->measureset->id.'/'.$measure->id.'/root-image'
                : null,
        ];
    }
}
