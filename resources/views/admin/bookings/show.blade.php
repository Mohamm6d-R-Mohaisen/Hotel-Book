@extends('admin.layouts.master')
@section('title', 'تفاصيل الحجز')

@section('content')
<div class="container py-5" style="font-family: 'Cairo', sans-serif;">

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- بطاقة الحجز -->
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

                <!-- رأس البطاقة -->
                <div class="bg-success text-white text-center p-4">
                    <h3 class="fw-bold mb-1">
                        <i class="bi bi-check-circle-fill me-2"></i> تم الحجز بنجاح
                    </h3>
                    <span class="badge bg-light text-success fs-6 px-3 py-2 rounded-pill">
                        رقم الحجز: {{ $booking->booking_number }}
                    </span>
                </div>

                <div class="row g-0">
                    <!-- صورة الغرفة -->
                    <div class="col-lg-5">
                        @if ($booking->room->images->first())
                            <img src="{{ $booking->room->images->first()->image}}"
                                 alt="صورة الغرفة"
                                 class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/800x600?text=No+Image"
                                 alt="صورة افتراضية"
                                 class="w-100 h-100" style="object-fit: cover;">
                        @endif
                    </div>

                    <!-- تفاصيل الحجز -->
                    <div class="col-lg-7 bg-white p-4">

                        <h5 class="fw-bold text-secondary mb-4">تفاصيل الحجز</h5>

                        <table class="table table-borderless align-middle mb-4">
                            <tbody>
                                <tr>
                                    <th class="text-muted" style="width: 35%;">
                                        <i class="bi bi-door-closed-fill me-2 text-success"></i> الغرفة
                                    </th>
                                    <td>{{ $booking->room->title }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="bi bi-calendar-event-fill me-2 text-primary"></i> تواريخ الإقامة
                                    </th>
                                    <td>
                                        {{ $booking->check_in->format('Y-m-d') }} <strong>إلى</strong> {{ $booking->check_out->format('Y-m-d') }}
                                        <br>
                                        ({{ $booking->nights }} ليلة)
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="bi bi-cash-coin me-2 text-warning"></i> المجموع
                                    </th>
                                    <td class="fw-bold text-success fs-5">
                                        $ {{ number_format($booking->total_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="bi bi-credit-card-2-front-fill me-2 text-info"></i> حالة الدفع
                                    </th>
                                    <td>
                                        <span class="badge bg-success px-3 py-2 rounded-pill">
                                            <i class="bi bi-check-circle-fill"></i> مدفوع بالكامل
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="bi bi-gear-fill me-2 text-secondary"></i> حالة الحجز
                                    </th>
                                    <td>
                                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                                            {{ $booking->status === 'confirmed' ? 'مؤكد' : 'معلق' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="bi bi-stripe me-2 text-dark"></i> معرف الدفع
                                    </th>
                                    <td><code>{{ $booking->payment_intent_id }}</code></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- أزرار الإجراءات -->
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="me-2">
                                @csrf
                                <button type="submit" class="btn btn-danger px-4">
                                    <i class="bi bi-x-circle me-2"></i> إلغاء الحجز
                                </button>
                            </form>

                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary px-4">
                               </i>Cancel Booking
                            </a>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
