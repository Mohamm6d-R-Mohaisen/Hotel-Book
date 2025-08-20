@extends('frontend.home.layout')
@section('content')

<!-- Blog Section Begin -->
    <section class="blog-section blog-page spad">
        <div class="container">
            <div class="row">
                @foreach($blogs as $blog)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item set-bg" data-setbg="{{ asset($blog->image) }}">
                        <div class="bi-text">

                            <h4><a href="{{route('blogs.show',$blog->id)}}">{{$blog->title}}</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> {{$blog->created_at->format('Y-m-d ')}}</div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
               <!-- Pagination -->
            <div id="pagination-links" class="room-pagination mt-4">
                {{ $blogs->links() }}
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
