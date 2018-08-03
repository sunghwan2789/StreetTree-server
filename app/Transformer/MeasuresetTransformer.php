<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Entity\Measureset;

class MeasuresetTransformer extends TransformerAbstract
{
    /**
     * @inheritdoc
     */
    protected $availableIncludes = ['author', 'measures'];

    /**
     * @inheritdoc
     */
    protected $defaultIncludes = ['author', 'measures'];

    public function transform(Measureset $measureset)
    {
        return [
            'measureset_id' => $measureset->id,
            'siteName' => $measureset->siteName,
            'clientName' => $measureset->clientName,
            'createdAt' => $measureset->createdAt->format('Y-m-d'),
        ];
    }

    public function includeAuthor(Measureset $measureset)
    {
        return $this->item($measureset->author, new UserTransformer);
    }

    public function includeMeasures(Measureset $measureset)
    {
        return $this->collection($measureset->measures, new MeasureTransformer);
    }
}
