<?php
namespace App\Serializer;

use League\Fractal\Serializer\ArraySerializer;

class ApiSerializer extends ArraySerializer
{
    /**
     * 'data' 루트 키 제거
     */
    public function collection($resourceKey, array $data)
    {
        return $data;
    }
}
