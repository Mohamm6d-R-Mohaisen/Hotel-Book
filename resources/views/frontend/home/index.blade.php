@extends('frontend.home.layout')
@section('content')

<!-- Hero Section Begin -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hero-text">
                    <h1>{{$slider->title}}</h1>
                    <p>{{$slider->sub_title}}.</p>

                </div>
            </div>
            <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                <div class="booking-form">
                    <h3>Booking Your Hotel</h3>
                    <form id="availabilityForm">
                        <div >
                            <label for="date-in">Check In:</label>
                            <br>
                            <input class="from-controll"  type="date" name="check_in" class="date-input" id="date-in" required>

                        </div>
                        <div >
                            <label for="date-out">Check Out:</label>
                            <br>
                            <input type="date" name="check_out" class="date-input" id="date-out" required>

                        </div>

                        <div class="select-option">
                            <label for="room">Room Type:</label>
                            <select name="room_type_id" id="room">
                                <option value="">Select Room Type</option>
                                @foreach($roomTypes as $roomtype)
                                <option value="{{ $roomtype->id }}">{{ $roomtype->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit">Check Availability</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="{{ asset($slider->image)}}"></div>

    </div>
</section>
<!-- Hero Section End -->

<!-- About Us Section Begin -->
<section class="aboutus-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-text">
                    <div class="section-title">
                        <span>About Us</span>
                        <h2>{{$about->title}}</h2>
                    </div>
                    <p class="f-para">{{$about->sub_title}}.</p>
                    <p class="s-para">{{$about->description}}.</p>
                    <a href="#" class="primary-btn about-btn">Read More</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-pic">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="{{asset($about->image1)}}" style="height: 300px;"alt="">
                        </div>
                        <div class="col-sm-6">
                            <img src="{{asset($about->image2)}}" style="height: 300px;" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Us Section End -->

<!-- Services Section End -->
<section class="services-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>What We Do</span>
                    <h2>Discover Our Services</h2>
                </div>
            </div>
        </div>
        <div class="row">
           @foreach($services as $service)
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="{{$service->icon}}"></i>
                    <h4>{{$service->name}}</h4>
                    <p>{{$service->description}}.</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Home Room Section Begin -->
<section class="hp-room-section">
    <div class="container-fluid">
        <div class="hp-room-items">
            <div class="row">
                @foreach($roomTypes as $roomType)
                <div class="col-lg-3 col-md-6">
                    <div class="hp-room-item set-bg" data-setbg="{{ asset($roomType->image) }}">
                        <div class="hr-text">
                            <h3>{{$roomType->name}}</h3>
                            <h2>{{$roomType->price_per_night}}$<span>/Pernight</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Size:</td>
                                        <td>{{$roomType->size}}M</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Capacity:</td>
                                        <td>{{$roomType->capicity}}Person</td>
                                    </tr>


                                </tbody>
                            </table>
                            <a href="{{ route('rooms.index') }}?type={{ $roomType->id }}" >Show Rooms</a>
                        </div>
                    </div>
                </div>
               @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Home Room Section End -->

<!-- Testimonial Section Begin -->
<section class="testimonial-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Testimonials</span>
                    <h2>What Customers Say?</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="testimonial-slider owl-carousel">
                    @foreach($custemerReviews as $review)
                    <div class="ts-item">
                        <p>{{$review->message}}.</p>
                        <div class="ti-author">

                            <h5> {{$review->author}}</h5>
                        </div>
                        <img src="{{asset($review->image)}}" style="width: 80px;" alt="">
                    </div>
                   @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial Section End -->

<!-- Blog Section Begin -->
<section class="blog-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Hotel News</span>
                    <h2>Our Blog & Event</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($bloges as $blog)
            <div class="col-lg-4">
                <div class="blog-item set-bg" data-setbg="{{ asset($blog->image) }}">
                    <div class="bi-text">

                        <h4><a href="#">{{$blog->title}}</a></h4>
                        <div class="b-time"><i class="icon_clock_alt"></i> {{$blog->created_at->format('Y-m-d ')}}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Blog Section End -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('availabilityForm');
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // ⚠️ هذا هو المفتاح

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            fetch("{{ route('home.available.rooms') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                alert('عدد الغرف المتاحة: ' + data.count);
            })
            .catch(error => {
                alert('حدث خطأ في الاتصال.');
                console.error(error);
            });
        });
    });
</script>
@endsection


