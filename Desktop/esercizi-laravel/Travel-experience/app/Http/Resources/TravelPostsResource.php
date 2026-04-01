<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Comment;

class TravelPostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'travel_date' => $this->travel_date,
            'user_id' => $this->user_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'author' => $this->user->name,
            'comments' => $this->comments->map(function (Comment $comment) {
                return [
                    'comment' => $comment->comment,
                    'author' => $comment->user->name,
                ];
            }),
        ];
    }
}
