<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Entity\File;
use App\Entity\User;

class FileTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'owner',
    ];

    public function transform(File $file)
    {
        return [
            'file_id'   => $file->id,
            'createdAt' => $file->createdAt->format(DATE_ATOM),
            'filename'  => $file->originalFilename,
            'checksum' => [
                'crc32' => $file->checksum_crc32,
            ],
            'mediaType' => $file->mediaType,
            'size'      => $file->size,
        ];
    }

    public function includeOwner(File $file)
    {
        return $this->item($file->owner, new UserTransformer());
    }
}
