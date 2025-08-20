@extends('admin.layouts.master')
@section('title')
    {{ __('admin.form.users') }}
@endsection
@push('styles')
    <link href="{{ asset('admin/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/plugins/datatables/datatable-custom.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')

    <div class="content d-flex flex-column flex-column-fluid customerView" id="kt_content">
        <div class="post d-flex flex-column-fluid chartAccount  customView" id="kt_post">
            <div id="kt_content_container" class="container-xxl accountTable">
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="page-content-header">
                        <div class="row justify-content-between">
                            <div class="col-3 col-sm-12 col-md-3 col-lg-3">
                                <h2 class="table-title">{{ __('admin.global.users') }}</h2>
                            </div>
                            <div class="col-8 col-sm-12 col-md-9 col-lg-9">
                                <div class="card-toolbar flex-row-fluid d-flex justify-content-end gap-5">
                                    <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
                                        Add New User

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-flush">
                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-solid w-250px ps-14"
                                        placeholder="Name Or Email"
                                        data-kt-docs-table-filter="search"
                                        id="search_input">
                                </div>
                                <div id="kt_ecommerce_report_views_export" class="d-none"></div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div id="kt_ecommerce_sales_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                        id="oc_datatable">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 text-center">
                                                <th>#</th>
                                                <th>{{ __('admin.form.name') }}</th>
                                                <th>{{ __('admin.form.email') }}</th>
                                                <th>{{ __('admin.form.status') }}</th>
                                                <th>{{ __('admin.form.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        window.datatable_url = "{{ route('admin.users.datatable') }}";
    </script>
    <script src="{{ asset('admin/js_resource/users.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/datatable-init.js') }}"></script>
@endpush
@push('modals')

@endpush
