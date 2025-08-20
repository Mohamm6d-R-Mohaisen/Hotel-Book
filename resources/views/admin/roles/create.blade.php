@extends('admin.layouts.master')
@section('title') {{__('admin.roles.add_new_role')}} @endsection
@section('content')
<div class="content d-flex flex-column flex-column-fluid customerView" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid chartAccount  customView" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl accountTable">
          <!--begin::Main column-->
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="page-content-header">
                    <form action="{{ isset($role) ? route('admin.roles.update' ,  $role->id) : route('admin.roles.store') }}" method="post" id="kt_form" data-kt-redirect="{{ route('admin.roles.index') }}">
                        @csrf
                        @isset($role)
                            @method('PATCH')
                        @endif
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-5 ">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="role-name">{{__('admin.roles.role_name')}}</span>
                                <input type="text" value="{{ isset($role) ? $role->name:old('name')}}" style="font-size: 15px;" name="name" class="form-control form-control-solid w-250px ps-15 search-roll" placeholder="{{__('admin.roles.enter_role_name')}}" />
                                @error('name')
                                    <div class="form-control-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Wrapper-->
                        {{-- <h2 class="table-title">{{__('admin.role.permissions')}}</h2> --}}
                        <!--begin::Datatable-->
                        <table id="oc_datatable" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th>{{__('admin.roles.module_name')}}</th>
                                    <th>{{__('admin.roles.reading')}}</th>
                                    <th>{{__('admin.roles.create')}}</th>
                                    <th>{{__('admin.roles.delete')}}</th>
                                    <th>{{__('admin.roles.approve')}}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($permissions as $item)
                                    <tr>
                                        <td>{{__('admin.roles.' . $item->first()->parent)}}</td>

                                        @foreach ($item as $key=>$value)
                                            <td>
                                                <div class="form-check form-check-custom form-check-success form-check-solid keep-sign justify-content-center">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{$value->name}}" {{isset($rolePermissions) && in_array($value->id ,$rolePermissions)  ? 'checked' : ''}}>
                                                    {{-- <label class="form-check-label" for="">
                                                        {{__('admin.role.' . $value->name_key)}}
                                                    </label> --}}
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--end::Datatable-->
                        @error('permissions')
                            <div class="form-control-feedback text-danger">
                                {{ $message }}
                            </div>
                        @enderror

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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script src="{{ asset('admin/plugins/handleSubmitForm.js') }}"></script>
@endpush
