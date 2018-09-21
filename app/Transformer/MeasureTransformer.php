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

    protected $defaultIncludes = [
        'plate',
    ];

    public function transform(Measure $measure)
    {
        return [
            'measure_id'     => $measure->id,
            'measureset_id'  => $measure->measureset->id,
            'sequenceNumber' => $measure->sequenceNumber,
            'coordinates' => [
                'latitude'   => $measure->latitude,
                'longitude'  => $measure->longitude,
            ],
            'region' => [
                'siCode'     => $measure->siCode,
                'guCode'     => $measure->guCode,
                'dongCode'   => $measure->dongCode,
            ],
            'treeNumber'     => $measure->treeNumber,
            'isInstalled'    => $measure->isInstalled,
            'points'         => $measure->points,
            'rootImageUrl'   => $measure->rootImage !== null
                ? '/files/' . $measure->rootImage->id
                : null,
            'treeLocation'   => $measure->treeLocation,
            'memo'           => $measure->memo,
            'attachmentUrl'  => $measure->attachment !== null
                ? '/files/' . $measure->attachment->id
                : null,
        ];
    }

    public function includePlate(Measure $measure)
    {
        if ($measure->plate === null) {
            return $this->null();
        }
        return $this->item($measure->plate, new PlateTransformer());
    }
}
