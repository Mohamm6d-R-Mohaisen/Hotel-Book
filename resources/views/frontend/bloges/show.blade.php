@extends('frontend.home.layout')
@section('content')
<!-- Blog Details Hero Section Begin -->
    <section class="blog-details-hero set-bg" data-setbg="{{ asset($blog->image) }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="bd-hero-text">
                        <h2>{{$blog->title}}</h2>
                        <ul>
                            <li class="b-time"><i class="icon_clock_alt"></i> {{$blog->created_at->format('Y-m-d ')}}</li>
                            <li><i class="icon_profile"></i>{{$blog->author}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="blog-details-text">
                        <div class="bd-title">
                            <p>{{$blog->content}}</p>
                        </div>

                        <div class="bd-more-text">

                            <div class="bm-item">
                                <h4>Overview</h4>
                                <p>{{$blog->overview}}.</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->
@endsection
