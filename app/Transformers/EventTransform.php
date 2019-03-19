<?php

namespace App\Transformers;

use App\Models\Event;
use League\Fractal\TransformerAbstract;

class EventTransform extends TransformerAbstract
{
    public function transform(Event $entity)
    {
        return [
            'id' => $entity->id,
            'title' => $entity->title,
            'starts_at' => $entity->starts_at,
            'ends_at' => $entity->ends_at,
        ];
    }

}
