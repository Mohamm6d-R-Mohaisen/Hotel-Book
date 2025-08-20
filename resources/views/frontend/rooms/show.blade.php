@extends('frontend.home.layout')
@section('content')
<!-- Breadcrumb Section Begin -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Our Rooms</h2>
                    <div class="bt-option">
                        <a href="{{route('home')}}">Home</a>
                        <span>Rooms</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End -->

<!-- Room Details Section Begin -->
<section class="room-details-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="room-details-item">
                    <img src="{{$room->images->first()->image}}" alt="">
                    <div class="rd-text">
                        <div class="rd-title">
                            <h3>{{$room->roomType->name}}</h3>
                            <div class="rdt-right">

                                <a href="#" class="book-now-btn" data-room-id="{{ $room->id }}">Booking Now</a>
                            </div>
                        </div>
                        <h2>{{$room->roomType->price_per_night}}$<span>/Pernight</span></h2>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="r-o">Size:</td>
                                    <td>{{$room->roomType->size}} M</td>
                                </tr>
                                <tr>
                                    <td class="r-o">Capacity:</td>
                                    <td>{{$room->roomType->capicity}} persion</td>
                                </tr>

                            </tbody>
                        </table>
                        <p class="f-para">{{$room->overview}}.
                        </p>
                    </div>
                </div>


            </div>
            <div class="col-lg-4">
                <div class="room-booking">
                    <h3>Your Reservation</h3>
                    <form id="availabilityForm">
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        <p>Room ID: {{ $room->id }}</p>
                        <div>
                            <label for="date-in">Check In:</label>
                            <br>
                            <input class="from-controll" type="date" name="check_in" id="date-in" required>

                        </div>
                        <div>
                            <label for="date-out">Check Out:</label>
                            <br>
                            <input type="date" name="check_out" id="date-out" required>

                        </div>

                        <button type="submit">Check Availability</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Complete Your Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm" action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <!-- Hidden Input for Room ID -->
                    <input type="hidden" name="room_id" id="modal-room-id">

                    <div class="mb-3">
                        <label for="check_in" class="form-label">Check In Date</label>
                        <input type="date" class="form-control" name="check_in" id="check_in" required>
                    </div>

                    <div class="mb-3">
                        <label for="check_out" class="form-label">Check Out Date</label>
                        <input type="date" class="form-control" name="check_out" id="check_out" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Room Details Section End -->

@endsection
@push('scripts')
<script src="{{ asset('admin/plugins/handleSubmitForm.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookNowButtons = document.querySelectorAll('.book-now-btn');
        const bookingModal = document.getElementById('bookingModal');
        const modalRoomIdInput = document.getElementById('modal-room-id');

        bookNowButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // تعبئة رقم الغرفة في الحقل المخفي
                const roomId = this.getAttribute('data-room-id');
                modalRoomIdInput.value = roomId;

                // فتح المودال
                new bootstrap.Modal(bookingModal).show();
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('availabilityForm');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            // تأكد من أن room_id موجود
            if (!data.room_id) {
                alert('❌ خطأ: رقم الغرفة غير متوفر!');
                return;
            }

            // تأكد من أن التواريخ موجودة
            if (!data.check_in || !data.check_out) {
                alert('❌ يرجى تحديد تاريخ الدخول والمغادرة.');
                return;
            }

            fetch("{{ route('rooms.checkRoomAvailability') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                // إذا كانت الاستجابة 400 أو 422، نقرأ الرسالة
                if (!response.ok) {
                    return response.json().then(json => {
                        throw new Error(json.message || 'حدث خطأ غير معروف');
                    });
                }
                // إذا كانت الاستجابة 200، نقرأ JSON
                return response.json();
            })
            .then(json => {
                // هذه الحالة فقط عندما تكون الاستجابة 200 (الغرفة متاحة)
                if (json.available) {
                    alert('✅ ' + json.message);
                } else {
                    alert('❌ ' + json.message);
                }
            })
            .catch(error => {
                // يُعرض أي خطأ (400، 422، أو خطأ اتصال)
                alert('❌ ' + error.message);
                console.error('Error:', error);
            });
        });
    });
</script>
@endpush
