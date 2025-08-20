<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|
     */
    public function toArray($request)
    {
        $operations = view('admin.rooms.sub.operations', ['instance' => $this])->render();
//$room_type = $this->category->name;
        return [
            'id' => $this->id,
            'number' => $this->number,
//           'room_type' => $room_type,
            'status' => $this->status,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'operations' => $operations,
        ];
    }
}
