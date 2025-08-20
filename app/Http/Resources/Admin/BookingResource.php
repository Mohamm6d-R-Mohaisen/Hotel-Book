<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $operations = view('admin.bookings.sub.operations', ['instance' => $this])->render();
$user_name = $this->user->name ?? 'N/A';
$room_number = $this->room->number ?? 'N/A';
        return [
            'id'            => $this->id,
            'user_name'     => $user_name,
            'room_number'   => $room_number,
            'check_in'      => $this->check_in,
            'check_out'     => $this->check_out,
            'status'       => $this->status,
            'operations'    => $operations,
        ];
    }
}
