@extends('frontend.layout')

@section('content')
    <!-- Start OTP Verification Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{ route('verify-otp') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Verify Your Account</h3>
                                <p>Please enter the 6-digit verification code sent to your email.</p>
                            </div>
                            @if(session('success'))
                                <div class="alert alert-success text-center">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="form-group input-group">
                                <label for="code">Verification Code</label>
                                <input type="text" name="otp_code" id="code"
                                       class="form-control text-center"
                                       placeholder="Enter 6-digit code"
                                       maxlength="6"
                                       required autofocus>
                            </div>

                            <div class="button">
                                <button type="submit" class="btn btn-primary w-100">Verify</button>
                            </div>



                        </div>
                    </form>
                    <div class="resend text-center mt-3">
                        <p>Didn't receive the code?  <form action="{{ route('resend.otp') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link p-0">Resend Code</button>
                        </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End OTP Verification Area -->

@endsection