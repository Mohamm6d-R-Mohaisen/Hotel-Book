@extends('frontend.home.layout')
@section('content')
<!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-text">
                        <h2>Contact Info</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua.</p>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="c-o">Address:</td>
                                    <td>{{$settings->valueOf('address')}}</td>
                                </tr>
                                ;ldfkl;sdk;lsdfk;sdflksdflk;sdflsdfl;sd;lkasdfklsdfklsdlklk

                                <tr>
                                    <td class="c-o">Phone:</td>
                                    <td>{{$settings->valueOf('phone')}}</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Email:</td>
                                    <td>{{$settings->valueOf('email')}}</td>
                                </tr>
                                <tr>
                                    <td class="c-o">whatsapp:</td>
                                    <td>{{$settings->valueOf('whatsapp')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <form action="{{route('contact.submit')}}" method="post"   class="contact-form">
                            @csrf
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                                </div>

                                <div class="col-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                                </div>

                                <div class="col-12 text-center">


                                    <button type="submit" class="btn">Send Message</button>
                                </div>

                            </div>
                        </form>
                </div>
            </div>
            <div class="map">
                <iframe
                    src="{{$settings->valueOf('map_embed')}}"
                    height="470" style="border:0;" allowfullscreen=""></iframe>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector('form[action="{{ route('contact.submit') }}"]');

        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // منع الإرسال العادي

                const formData = new FormData(form);

                fetch("{{ route('contact.submit') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 200) {
                            // ✅ نجاح
                            Swal.fire({
                                icon: 'success',
                                title: 'تم بنجاح!',
                                text: data.message,
                                confirmButtonText: 'موافق'
                            }).then(() => {
                                form.reset(); // إعادة تعيين الفورم
                            });
                        } else {
                            // ❌ خطأ
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ!',
                                text: data.message,
                                confirmButtonText: 'موافق'
                            });
                        }
                    })
                    .catch(() => {
                        // ❌ خطأ في الاتصال
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: 'فشل الاتصال بالخادم. تحقق من الإنترنت وحاول مجددًا.',
                            confirmButtonText: 'موافق'
                        });
                    });
            });
        }
    });
</script>
@endsection
