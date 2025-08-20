<x-mail::message>
    # مرحبًا {{ $booking->user->name }}

    نشكرك على حجزك في فندقنا.
    رقم الحجز: **{{ $booking->booking_number }}**
    من: {{ $booking->check_in }} إلى {{ $booking->check_out }}

    لتأكيد الحجز، يرجى الضغط على الزر أدناه:

    <x-mail::button :url="$booking->confirmationUrl()">
        تأكيد الحجز
    </x-mail::button>

    إذا لم تقم بطلب هذا الحجز، يمكنك تجاهل هذا البريد.

    مع تحياتنا،
    فريق إدارة الفندق
</x-mail::message>
