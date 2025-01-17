<?php

declare(strict_types=1);

namespace App\Resources\Api\V1;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(?Request $request = null): array
    {
        /** @var Note $this */
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'content' => $this->content,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
