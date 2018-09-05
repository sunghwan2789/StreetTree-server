<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Entity\Frame;

class FrameTransformer extends TransformerAbstract
{
    public function transform(Frame $frame)
    {
        return [
            'frame_id'      => $frame->id,
            'width'         => $frame->width,
            'length'        => $frame->length,
            'height'        => $frame->height,
        ];
    }
}
