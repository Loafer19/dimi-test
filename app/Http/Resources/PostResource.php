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
        return [
            'title' => $this->title,
            'text' => $this->text,
            'posted_at' => $this->posted_at->format('m/d/Y H:i'),
            'comments' => $this->when($this->relationLoaded('comments'), CommentResource::collection($this->comments)),
        ];
    }
}
