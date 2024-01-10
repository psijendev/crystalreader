<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Models\Document;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        //getFirstMediaUrl();  getFirstMedia
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'isCatalog' => $this->isCatalog,
            'catalog_id' =>$this->catalog_id,
            //'user_id' => $this->user_id,
            'metadata' => $this->metadata,
            'attachment' => Document::find($this->id)->getFirstMediaUrl('documents')
        ];
        //return parent::toArray($request);
    }
}
