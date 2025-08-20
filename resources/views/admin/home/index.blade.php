@extends('admin.layouts.master')
@section('title', __('Dashboard'))

@section('content')

    <div class="page-content-header mb-5">
        <h2 class="table-title">{{ __('Dashboard') }}</h2>
        <p class="text-muted">{{ __('Overview of your hotel management system') }}</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Quick Stats Cards -->
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card card-body text-center shadow-sm">
                <h5>{{ $data['totalRooms'] }}</h5>
                <p class="text-muted mb-0">{{ __('Total Rooms') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body text-center shadow-sm">
                <h5>{{ $data['activeBookings']->count() }}</h5>
                <p class="text-muted mb-0">{{ __('Active Bookings') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body text-center shadow-sm">
                <h5>{{ $data['todayCheckIns'] }}</h5>
                <p class="text-muted mb-0">{{ __('Today Check-ins') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body text-center shadow-sm">
                <h5>{{ $data['todayCheckOuts'] }}</h5>
                <p class="text-muted mb-0">{{ __('Today Check-outs') }}</p>
            </div>
        </div>
    </div>

    <!-- Available Rooms Now -->
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h4>{{ $data['availableRoomsNow'] }}</h4>
                    <p class="mb-0">{{ __('Available Rooms Now') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Available Rooms -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">{{ __('Search Available Rooms') }}</h5>
        </div>
        <div class="card-body">
            <form id="searchRoomsForm">
                <div class="row">
                    <div class="col-md-4">
                        <label>{{ __('Check-in Date') }}</label>
                        <input type="date" name="check_in" id="check_in" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('Check-out Date') }}</label>
                        <input type="date" name="check_out" id="check_out" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('Room Type') }}</label>
                        <select name="room_type_id" id="room_type_id" class="form-control">
                            <option value="">{{ __('All Types') }}</option>
                            @foreach(\App\Models\RoomType::all() as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                </div>
            </form>

            <!-- Results -->
            <div id="searchResults" class="mt-4" style="display: none;">
                <h6>{{ __('Available Rooms') }}: <span id="roomCount"></span></h6>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Room Number') }}</th>
                            <th>{{ __('Room Type') }}</th>
                            <th>{{ __('Price per Night') }}</th>
                            <th>{{ __('Status') }}</th>
                        </tr>
                        </thead>
                        <tbody id="roomsList">
                        <!-- بيانات الغرف ستُضاف هنا -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Bookings -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">{{ __('Active Bookings') }}</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('User Name') }}</th>
                        <th>{{ __('Room Number') }}</th>
                        <th>{{ __('Check-in Date') }}</th>
                        <th>{{ __('Check-out Date') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data['activeBookings'] as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->name ?? 'N/A' }}</td>
                            <td>{{ $booking->room->number ?? 'N/A' }}</td>
                            <td>{{ $booking->check_in }}</td>
                            <td>{{ $booking->check_out }}</td>
                            <td><span class="badge bg-info">{{ $booking->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">{{ __('No active bookings found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Check-out Bookings -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">{{ __('Check-out Bookings') }}</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('User Name') }}</th>
                        <th>{{ __('Room Number') }}</th>
                        <th>{{ __('Check-in Date') }}</th>
                        <th>{{ __('Check-out Date') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data['checkOutBookings'] as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->name ?? 'N/A' }}</td>
                            <td>{{ $booking->room->number ?? 'N/A' }}</td>
                            <td>{{ $booking->check_in }}</td>
                            <td>{{ $booking->check_out }}</td>
                            <td><span class="badge bg-secondary">{{ $booking->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">{{ __('No check-out bookings found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">{{ __('Latest Registered Users') }}</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Joined At') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data['lastUsers'] as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">{{ __('No users found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection

@push('scripts')


    <!-- Charts & Maps Scripts -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <script>
        document.getElementById('searchRoomsForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            try {
                const response = await fetch("{{ route('admin.home.getAvailableRooms') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(data).toString()
                });

                if (!response.ok) {
                    throw new Error('Network error');
                }

                const result = await response.json();
                const resultsDiv = document.getElementById('searchResults');
                const roomsList = document.getElementById('roomsList');
                const roomCount = document.getElementById('roomCount');

                if (result.available_rooms && result.available_rooms.length > 0) {
                    roomsList.innerHTML = '';
                    result.available_rooms.forEach((room, index) => {
                        roomsList.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${room.room_number}</td>
                    <td>${room.room_type}</td>
                    <td>${room.price_per_night}</td>
                    <td><span class="badge bg-success">${room.status}</span></td>
                </tr>`;
                    });
                    roomCount.textContent = result.count;
                    resultsDiv.style.display = 'block';
                } else {
                    roomsList.innerHTML = '<tr><td colspan="5">لا توجد غرف متاحة في هذه الفترة.</td></tr>';
                    roomCount.textContent = 0;
                    resultsDiv.style.display = 'block';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('حدث خطأ أثناء البحث. تحقق من تواريخ الدخول والخروج.');
            }
        });
    </script>
@endpush
