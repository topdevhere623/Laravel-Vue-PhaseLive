<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThreadPreviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'messages' => [],
            'last_message' => new MessageResource($this->last_message),
            'users' => MessageReceiversResource::collection($this->users),
            'type' => $this->type,
            'is_liked' => $this->is_liked,
            'likes_count' => $this->likes_count,
            'read_at' => $this->pivot->read_at
        ];
    }
}
