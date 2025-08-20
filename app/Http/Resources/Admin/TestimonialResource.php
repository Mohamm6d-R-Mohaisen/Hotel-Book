<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $operations = view('admin.testimonials.sub.operations', ['instance' => $this])->render();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'operations' => $operations,
        ];
    }
}
