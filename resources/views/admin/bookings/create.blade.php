@extends('admin.layouts.master')
@section('title', isset($booking) ? __('admin.global.edit_about') : __('admin.global.add_new_about'))
@section('content')

<form id="kt_form" class="form row d-flex flex-column flex-lg-row addForm"
{{--    data-kt-redirect="{{ route('admin.bookings.index') }}"--}}
    action="{{ isset($booking) ? route('admin.bookings.update', $booking->id) : route('admin.bookings.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($booking)
        @method('PATCH')
    @endisset


    <!-- Main Form -->
    <div class="d-flex flex-column flex-row-fluid gap-3 col-lg-9">
        <div class="card card-flush generalDataTap">
            <div class="salesTitle">
            </div>
            <div class="card-body pt-0">

                <div class="mb-5">
                    <label class="required form-label">users </label>
                    <select name="user_id" class="form-select" required>
                        <option value="" disabled {{ !isset($booking) ? 'selected' : '' }}>select user</option>

                        @foreach($users as $user)
                            @if(isset($booking))
                            <option value="{{ $user->id }}"

                                        @if(isset($users) && $booking->user_id == $user->id) selected @endif>

                                {{ $user->name }}
                            </option>
                            @else
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                            @endif
                        @endforeach

                    </select>
                </div>


                <div class="mb-5">
                    <label class="required form-label">Rooms</label>
                    <select name="room_id" id="room_id" class="form-select" required>
                        <option value="" disabled {{ !isset($booking) ? 'selected' : '' }}>Select room</option>

                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                    data-price="{{ $room->roomType->price_per_night }}"
                                    @if(isset($booking) && $booking->room_id == $room->id) selected @endif>
                                {{ $room->number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="required form-label">check_in</label>
                    <input type="date" id="check_in" name="check_in" class="form-control" required
                           value="{{ old('check_in', $booking->check_in ?? '') }}">
                </div>
                <div class="mb-5">
                    <label class="required form-label">check_out</label>
                    <input type="date" id="check_out" name="check_out" class="form-control" required
                           value="{{ old('check_out', $booking->check_out ?? '') }}">
                </div>

                <div class="mb-5">
                    <label class="required form-label">total_amount</label>
                    <input type="text" id="total_amount" name="total_amount" class="form-control" required
                           value="{{ old('total_amount', $booking->total_amount ?? '') }}">



                </div>


</div>


    <div class="page-buttuns mt-5">
                <div class="row justify-content-between">
                    <div class="d-flex justify-content-end right">
                        <button type="submit" id="kt_submit" class="btn btn-primary me-5">
                            <span class="indicator-label">Save</span>

                        </button>
                        <a href="{{ route('admin.bookings.index') }}" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5 cancel">Cancel</a>
                    </div>
                </div>
            </div>
</form>

@endsection

@push('scripts')

<script src="{{ asset('admin/plugins/handleSubmitForm.js') }}"></script>
<script src="{{ asset('admin/plugins/image-input.js') }}"></script>
<script>
    $.post('/admin/bookings/create', data)
        .done(res => {
            if (res.redirect_url) {
                window.location.href = res.redirect_url;   // أو .replace(...)
            }
        })
        .fail(err => console.error(err));
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomSelect = document.getElementById('room_id');
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const totalAmountInput = document.getElementById('total_amount');

        function calculateTotal() {
            // 1. جلب السعر من الغرفة المختارة
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            const pricePerNight = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) : 0;

            if (!pricePerNight || isNaN(pricePerNight)) {
                totalAmountInput.value = '';
                return;
            }

            // 2. جلب التواريخ
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);

            // 3. التحقق من صحة التواريخ
            if (!checkInInput.value || !checkOutInput.value || checkIn >= checkOut) {
                totalAmountInput.value = '';
                return;
            }

            // 4. حساب عدد الليالي
            const timeDiff = checkOut.getTime() - checkIn.getTime();
            const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

            // 5. حساب المجموع
            const total = nights * pricePerNight;

            // 6. عرض النتيجة
            totalAmountInput.value = total.toFixed(2);
        }

        // الاستماع لأحداث التغيير
        roomSelect?.addEventListener('change', calculateTotal);
        checkOutInput?.addEventListener('change', calculateTotal); // عند تغيير تاريخ الخروج
        checkInInput?.addEventListener('change', calculateTotal);  // اختيارًا إضافيًا

        // حساب القيمة عند تحميل الصفحة (مهم للتعديل)
        if (roomSelect.value && checkInInput.value && checkOutInput.value) {
            calculateTotal();
        }
    });
</script>

@endpush
