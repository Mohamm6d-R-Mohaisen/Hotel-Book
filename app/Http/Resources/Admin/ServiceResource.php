<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $operations = view('admin.services.sub.operations', ['instance' => $this])->render();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'operations' => $operations,
        ];
    }
}
