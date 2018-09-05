<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Entity\Measureset;

class MeasuresetTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'author',
        'measures',
    ];

    public function transform(Measureset $measureset)
    {
        return [
            'measureset_id' => $measureset->id,
            'siteName'      => $measureset->siteName,
            'clientName'    => $measureset->clientName,
            'createdAt'     => $measureset->createdAt->format('Y-m-d'),
            'salespersonName' => $measureset->salespersonName,
            'deliveryTarget'  => $measureset->deliveryTarget,
            'deliveryDate'    => $measureset->deliveryDate->format('Y-m-d'),
            'differenceValue' => $measureset->differenceValue,
        ];
    }

    public function includeAuthor(Measureset $measureset)
    {
        return $this->item($measureset->author, new UserTransformer());
    }

    public function includeMeasures(Measureset $measureset)
    {
        return $this->collection($measureset->measures, new MeasureTransformer());
    }
}
