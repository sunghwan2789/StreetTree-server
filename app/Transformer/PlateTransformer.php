<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Entity\Plate;

class PlateTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'frame',
    ];

    public function transform(Plate $plate)
    {
        return [
            'plate_id'      => $plate->id,
            'width'         => $plate->width,
            'length'        => $plate->length,
            'innerDiameter' => $plate->innerDiameter,
            'height'        => $plate->height,
        ];
    }

    public function includeFrame(Plate $plate)
    {
        return $this->item($plate->frame, new FrameTransformer());
    }
}
