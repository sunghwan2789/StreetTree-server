<?php
namespace App\Transformer;

use League\Fractal;
use App\Entity\User;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'user_id'  => $user->id,
            'username' => $user->username,
            'fullName' => $user->fullName,
        ];
    }
}
