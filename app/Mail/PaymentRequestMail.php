<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentRequestMail extends Mailable
{
use Queueable, SerializesModels;

public $booking;
public $paypalLink;

public function __construct(Booking $booking, $paypalLink)
{
    $this->booking = $booking;
    $this->paypalLink = $paypalLink;
}

public function envelope(): Envelope
{
    return new Envelope(
        subject: 'تأكيد الحجز - إتمام الدفع مطلوب - رقم الحجز: ' . $this->booking->booking_number,
    );
}

public function content(): Content
{
    return new Content(
        view: 'mail.booking.payment-request',
        with: [
            'booking' => $this->booking,
            'paypalLink' => $this->paypalLink,
        ]
    );
}

public function attachments(): array
{
    return [];
}
}
