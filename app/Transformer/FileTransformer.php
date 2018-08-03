<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Entity\File;
use App\Entity\User;

class FileTransformer extends TransformerAbstract
{
    /**
     * @inheritdoc
     */
    protected $availableIncludes = ['owner'];

    /**
     * @inheritdoc
     */
    protected $defaultIncludes = ['owner'];

    public function transform(File $file)
    {
        return [
            'file_id' => $file->id,
            'createdAt' => $file->createdAt->format(DATE_RFC3339_EXTENDED),
            'hash' => [
                'crc32' => $file->hash_crc32,
            ],
            'mediaType' => $file->mediaType,
            'filename' => $file->originalFilename,
            'size' => $file->size,
        ];
    }

    public function includeOwner(File $file)
    {
        return $this->item($file->owner, new UserTransformer);
    }
}
