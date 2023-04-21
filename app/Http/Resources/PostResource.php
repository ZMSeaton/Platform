<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'type' => 'post',
            'id' => $this->id,
            'attributes' => [
                'text' => $this->text,
                'user_id' => $this->user_id,
                'updated_at' => $this->updated_at->format("F jS")
            ]
        ];
    }
}
