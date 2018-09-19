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
            'attachmentUrl' => $plate->attachment
                ? '/files/' . $plate->attachment->id
                : null,
        ];
    }

    public function includeFrame(Plate $plate)
    {
        return $this->item($plate->frame, new FrameTransformer());
    }

    public function includeAttachment(Plate $plate)
    {
        if ($plate->attachment == null) {
            return $this->null();
        }
        return $this->item($plate->attachment, new FileTransformer());
    }
}
