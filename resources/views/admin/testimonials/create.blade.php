@extends('admin.layouts.master')
@section('title', isset($testimonial) ? __('admin.global.edit_slider') : __('admin.global.add_new_slider'))

@section('content')
    <form id="kt_form" class="form row d-flex flex-column flex-lg-row addForm" data-kt-redirect="{{ route('admin.testimonials.index') }}"
          action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial->id) : route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @isset($testimonial)
            @method('PATCH')
        @endisset

        <div class="page-content-header mb-5">
            <h2 class="table-title">{{ isset($testimonial) ? __('admin.global.edit_slider') : __('admin.global.add_new_slider') }}</h2>
        </div>

        <!-- Sidebar: Status and Logo Image Section -->
        <div class="d-flex flex-column gap-5 col-lg-3 mb-7">
            <!-- slider Logo Section -->
            <div class="card card-flush">
                <div class="card-header justify-content-center p-5">
                    <div class="card-toolbar">
                        <div class="image-input image-input-outline" data-kt-image-input="true">
                            <div class="image-input-wrapper w-200px h-200px" style="background-image: url({{ isset($testimonial) && $testimonial->image ? asset($testimonial->image) : asset('admin_assets/media/svg/files/blank-image.svg') }})"></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change image">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel image">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                  data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove Image">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                            <input type="hidden" name="remove_image" value="0" data-kt-image-input="remove" />

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Main Content: slider Details -->
        <div class="d-flex flex-column flex-row-fluid gap-3 col-lg-9">
            <div class="card card-flush">
                <div class="card-body">
                    <div class="mb-5">
                        <label class="required form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter slider title"
                               value="{{ isset($testimonial) ? $testimonial->name : '' }}">
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Position</label>
                        <input type="text" name="position" class="form-control" placeholder="Enter slider subtitle"
                               value="{{ isset($testimonial) ? $testimonial->position : '' }}">
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Message</label>
                        <textarea name="message" id="" cols="30" rows="10" class="form-control">{{ isset($testimonial) ? $testimonial->message : '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="page-buttuns mt-5">
                <div class="row justify-content-between">
                    <div class="d-flex justify-content-end right">
                        <button type="submit" id="kt_submit" class="btn btn-primary me-5">
                            <span class="indicator-label">Save</span>

                        </button>
                        <a href="{{ route('admin.testimonials.index') }}" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5 cancel">Cancel</a>
                    </div>
                </div>
            </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('admin/plugins/handleSubmitForm.js') }}"></script>
    <script src="{{ asset('admin/plugins/image-input.js') }}"></script>

@endpush
