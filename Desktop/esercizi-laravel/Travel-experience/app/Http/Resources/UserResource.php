<?php

namespace App\Http\Resources;


use App\Models\TravelPost;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'posts' => $this->posts->map(function (TravelPost $post) {
                return [
                    'title' => $post->title,
                    'description' => $post->description,
                    'location' => $post->location
                ];
            })
        ];
    }
}
