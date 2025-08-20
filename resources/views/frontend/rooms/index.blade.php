@extends('frontend.home.layout')
@section('content')
  <!-- Filter -->
    <div class="container my-4">
        <form id="filter-form" class="d-flex">
            <select name="type" id="room-type" class="form-control me-2">
                <option value="">-- All Types --</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">
                        {{ ucfirst($type->name) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    <!-- Rooms Section -->
    <section class="rooms-section spad">
        <div class="container">
            <div id="rooms-container" class="row">
               @forelse($rooms as $room)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="room-item">
            <img src="{{asset($room->images->first()->image) }}" alt="{{ $room->title }}">
            <div class="ri-text">
                <h4>{{ $room->title }} ({{ $room->roomType->name }})</h4>
                <h3>{{ $room->roomType->price_per_night }}$<span>/Pernight</span></h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="r-o">Size:</td>
                            <td>{{ $room->roomType->size }}</td>
                        </tr>
                        <tr>
                            <td class="r-o">Capacity:</td>
                            <td>Max person {{ $room->roomType->capacity }}</td>
                        </tr>
                    </tbody>
                </table>
                <a href="{{ route('rooms.show', $room->id) }}" class="primary-btn">More Details</a>
            </div>
        </div>
    </div>
@empty
    <p class="text-center">No rooms found.</p>
@endforelse
            </div>

            <!-- Pagination -->
            <div id="pagination-links" class="room-pagination mt-4">
                {{ $rooms->links() }}
            </div>
        </div>
    </section>
    @endsection
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // دالة لجلب الغرف
        function fetchRooms(url = "{{ route('rooms.filter') }}") {
            let formData = $('#filter-form').serialize();

            // إضافة loading
            $('#loading').removeClass('d-none');

            $.ajax({
                url: url,
                method: 'GET',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    $('#rooms-container').html(res.html);
                    $('#pagination-links').html(res.pagination);
                    // تحديث الرابط في المتصفح
                    window.history.pushState({}, '', '?' + formData);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('حدث خطأ أثناء جلب الغرف. يرجى المحاولة لاحقًا.');
                },
                complete: function() {
                    $('#loading').addClass('d-none');
                }
            });
        }

        // عند إرسال النموذج
        $('#filter-form').on('submit', function(e) {
            e.preventDefault();
            fetchRooms();
        });

        // عند تغيير نوع الغرفة
        $('#room-type').on('change', function() {
            fetchRooms();
        });

        // عند الضغط على رابط الباجينيشن
        $(document).on('click', '#pagination-links a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href'); // الرابط يحتوي على ?page=2&type=1
            fetchRooms(url);
        });

        // اختيار تلقائي إذا كان هناك نوع في الرابط
        const urlParams = new URLSearchParams(window.location.search);
        const type = urlParams.get('type');
        if (type) {
            $('#room-type').val(type);
        }
    });
</script>
@endpush

