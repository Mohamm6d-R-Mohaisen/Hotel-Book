<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room;

class UpdateRoomStatus extends Command
{
protected $signature = 'bookings:update-statuses';
protected $description = 'تحديث حالة الغرف: هل بدأت؟ هل انتهت؟';

public function handle()
{
$rooms = Room::where('status', '!=', 'maintenance')->get();

foreach ($rooms as $room) {
// هل هناك حجز نشط الآن؟ (بدأ ولم ينتهِ)
$hasActiveBooking = $room->bookings()
->whereNotIn('status', ['cancelled', 'checked_out'])
->where('check_in', '<=', now())
->where('check_out', '>', now())
->exists();

$newStatus = $hasActiveBooking ? 'occupied' : 'available';

if ($room->status !== $newStatus) {
$room->status = $newStatus;
$room->saveQuietly(); // لا يُطلق أحداث
}
}

$this->info('تم تحديث حالات الغرف.');
}
}
