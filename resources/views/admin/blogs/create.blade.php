@extends('admin.layouts.master')
@section('title', isset($blog) ? __('admin.global.edit_about') : __('admin.global.add_new_about'))
@section('content')

<form id="kt_form" class="form row d-flex flex-column flex-lg-row addForm"
    data-kt-redirect="{{ route('admin.blogs.index') }}"
    action="{{ isset($blog) ? route('admin.blogs.update', $blog->id) : route('admin.blogs.store') }}"
    method="POST" encblog="multipart/form-data">
    @csrf
    @isset($blog)
        @method('PATCH')
    @endisset

<div class="d-flex flex-column gap-5 col-lg-3 mb-7">
        <div class="card card-flush">
            <div class="card-header justify-content-center">
                <h3 class="card-title">Image</h3>
            </div>
            <div class="card-header card-header justify-content-center p-5">
                <div class="card-toolbar">
                    <div class="image-input image-input-outline" data-kt-image-input="true">
                        <div class="image-input-wrapper w-200px h-200px"
                            style="background-image: url({{ isset($blog) && $blog->image ? asset($blog->image) : asset('admin_assets/media/svg/files/blank-image.svg') }})">
                        </div>
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Image">
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                        </label>
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel Image">
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
    <!-- Main Form -->
    <div class="d-flex flex-column flex-row-fluid gap-3 col-lg-9">
        <div class="card card-flush generalDataTap">
            <div class="salesTitle">
                <h3>About Details</h3>
            </div>
            <div class="card-body pt-0">
                <div class="mb-5">
                    <label class="required form-label">Title</label>
                    <input type="text" name="title" class="form-control" required
                        value="{{ old('title', $blog->title ?? '') }}">
                </div>
                <div class="mb-5">
                    <label class="required form-label">Content</label>
                   <textarea name="content" rows="6" class="form-control"
                        required>{{ old('content', $about->content ?? '') }}</textarea>
                </div>
                    <div class="mb-5">
                    <label class="required form-label">Author</label>
                    <input type="text" name="author" class="form-control" required
                           value="{{ old('author', $blog->author ?? '') }}">
                </div>
                    <div class="mb-5">
                    <label class="required form-label">Overview</label>
                    <textarea name="overview" rows="3" class="form-control"
                        required>{{ old('overview', $about->overview ?? '') }}</textarea>
                </div>







    <div class="page-buttuns mt-5">
                <div class="row justify-content-between">
                    <div class="d-flex justify-content-end right">
                        <button blog="submit" id="kt_submit" class="btn btn-primary me-5">
                            <span class="indicator-label">Save</span>

                        </button>
                        <a href="{{ route('admin.blogs.index') }}" id="kt_ecommerce_add_product_cancel"
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
