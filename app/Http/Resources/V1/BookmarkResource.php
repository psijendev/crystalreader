<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookmarkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // No need to show user_id, if controller uses Auth facade to get values based on user_id "user_id" => $this->user_id,
            "document_id" => $this->document_id,
            "status" => "Active"
        ];
    }
}
