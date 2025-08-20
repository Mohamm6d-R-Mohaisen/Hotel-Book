@extends('admin.layouts.master')
@section('title')
    {{ __('admin.global.add_new_user') }}
@endsection
@section('content')
    <form id="kt_form" class="form" method="post" data-kt-redirect="{{ route('admin.users.index') }} "
            action="{{ isset($user) ? route('admin.users.update' ,  $user->id) : route('admin.users.store') }}">
        @csrf
        @isset($user)
            @method('PATCH')
        @endif

        <div class="">
            <div class="page-content-header">
                <h2 class="table-title">{{ __('admin.global.add_new_user') }}</h2>
            </div>
            <div class="card card-flush">
                <div class="card-body">
                    <div class="new-user-form" id="new-user-form">
                        <div class="formContent">

                            <div class="row g-9 mb-7">
                                <div class="fv-row">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="required">{{ __('admin.form.name') }}</span>
                                    </label>
                                    <input type="text" class="form-control"
                                        placeholder="" name="name" value="{{ isset($user) ? $user->name:'' }}">
                                </div>
                                <div class="fv-row">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="required">{{ __('admin.form.phone_code') }}</span>
                                    </label>
                                    <input type="text" class="form-control"
                                        placeholder="972" name="phone_code" value="{{ isset($user) ? $user->phone_code:'' }}">
                                </div>
                                <div class="fv-row">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="required">{{ __('admin.form.phone') }}</span>
                                    </label>
                                    <input type="text" class="form-control"
                                        placeholder="596123456" name="phone" value="{{ isset($user) ? $user->phone:'' }}" required>
                                </div>
                                <div class="fv-row">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="required">{{ __('admin.form.email') }}</span>
                                    </label>
                                    <input type="email" class="form-control"
                                        placeholder="" name="email" value="{{ isset($user) ? $user->email:'' }}">
                                </div>
                                <div class="fv-row">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="required">{{ __('admin.form.password') }}</span>
                                    </label>
                                    <input type="password" class="form-control" placeholder="" name="password" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-buttuns mt-5">
                <div class="row justify-content-between">
                    <div class="d-flex justify-content-end right">
                        <button type="submit" id="kt_submit" class="btn btn-primary me-5">
                            <span class="indicator-label">Save</span>

                        </button>
                        <a href="{{ route('admin.admins.index') }}" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5 cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('scripts')
  <script src="{{ asset('admin/plugins/handleSubmitForm.js') }}"></script>
  <script src="{{ asset('admin/plugins/image-input.js') }}"></script>
@endpush
