<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransform extends TransformerAbstract
{
    protected $defaultIncludes = ['profile'];

    public function transform(User $entity)
    {
        return [
            'id'        => $entity->id,
            'username'  => $entity->username,
            'name'      => $entity->name,
            'cpf'       => $entity->cpf
        ];
    }

    public function includeProfile(User $user)
    {
        return $this->item($user->profile(), new ProfileTransform);
    }

}
