@extends('admin.layouts.master')
@section('title', isset($room) ? __('admin.global.edit_about') : __('admin.global.add_new_about'))
@section('content')

    <form id="kt_form" class="form row d-flex flex-column flex-lg-row addForm"
          data-kt-redirect="{{ route('admin.rooms.index') }}"
          action="{{ isset($room) ? route('admin.rooms.update', $room->id) : route('admin.rooms.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @isset($room)
            @method('PATCH')
        @endisset
        <div class="d-flex flex-column gap-5 col-md-4 mb-7" id="media" role="tabpanel">

            <!-- Media Upload Tab -->
                        <div class="mx-5" id="media_repeater">
                            <div class="form-group draggable" >
                                <div data-repeater-list="media_repeater">
                                    @if(isset($room) && $room->images->isNotEmpty())
                                        @foreach ($room->images as $image)
                                            <div data-repeater-item class="draggable" style="border: 1px solid #988f8f40; border-radius: 10px; margin: 20px; padding: 15px; width: fit-content;">
                                                <div class="form-group row mb-5">
                                                    <div class="card-toolbar">
                                                        <a href="#" class="btn btn-icon btn-hover-light-primary draggable-handle">
                                    <span class="svg-icon svg-icon-2x">
                                        <!-- أيقونة السحب -->
                                    </span>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="image-input image-input-empty" data-kt-image-input="true" style="background-image:  url({{ isset($image)  ? asset($image->image) : asset('admin_assets/media/svg/files/blank-image.svg') }})">
                                                            <input type="hidden" name="images_current[]" value="{{ $image->image }}" />
                                                            <div class="image-input-wrapper w-125px h-125px"></div>
                                                            <input type="hidden" name="id[]" value="{{ $image->id }}">                                                            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                   data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change avatar">
                                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                                <input type="file" name="images[]" accept=".png, .jpg, .jpeg" />
                                                            </label>
                                                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                  data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                  data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-9">
                                                            <i class="la la-trash-o fs-3"></i> حذف
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else

                                        <div data-repeater-item class="draggable" style="border: 1px solid #988f8f40;border-radius: 10px;margin: 20px;padding: 15px; width: fit-content;">
                                            <div class="form-group row mb-5 ">

                                                <div class="col-md-6">
                                                    <div class="image-input image-input-empty" data-kt-image-input="true" style="background-image: url({{ asset('admin_assets/media/svg/avatars/blank.svg') }})">
                                                        <div class="image-input-wrapper w-125px h-125px"></div>
                                                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                               data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change avatar">
                                                            <i class="bi bi-pencil-fill fs-7"></i>
                                                            <input type="file" name="images[]" accept=".png, .jpg, .jpeg" />
                                                             <input type="hidden" name="avatar_remove" />
                                                        </label>
                                                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                              data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel avatar">
                                                            <i class="bi bi-x fs-2"></i>
                                                        </span>
                                                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                              data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove avatar">
                                                            <i class="bi bi-x fs-2"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt- mt-md-9">
                                                        <i class="la la-trash-o fs-3"></i>حذف
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mb-5">
                                <a href="javascript:;" data-repeater-create class="btn btn-primary px-10">
                                    <i class="la la-plus"></i> إضافة
                                </a>
                            </div>
                        </div>

                        <!--end::Repeater-->
                    </div>

        <!-- Main Form -->
        <div class="d-flex flex-column flex-row-fluid gap-3 col-lg-8">
            <div class="card card-flush generalDataTap">
                <div class="salesTitle">

                </div>
                <div class="card-body pt-0">
                    <div class="mb-5">
                        <label class="required form-label">Title</label>
                        <input type="text" name="title" class="form-control" required
                               value="{{ old('title', $room->title ?? '') }}">
                    </div>
                    <div class="mb-5">
                        <label class="required form-label">Number</label>
                        <input type="text" name="number" class="form-control" required
                               value="{{ old('number', $room->number ?? '') }}">
                    </div>
                    <div class="mb-5">
                        <label class="required form-label">Room Type</label>
                        <select name="room_type_id" class="form-select" required>
                            <option value="" disabled {{ !isset($room) ? 'selected' : '' }}>اختر نوع الغرفة</option>

                            @foreach($room_types as $type)
                                <option value="{{ $type->id }}"
                                        @if(isset($room) && $room->room_type_id == $type->id) selected @endif>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="required form-label">حالة الغرفة</label>
                        <select name="status" class="form-select" required>
                            <option value="" disabled {{ old('status', $room->status ?? '') == '' ? 'selected' : '' }}>
                                اختر حالة الغرفة
                            </option>

                            <!-- الحالة: متاح -->
                            <option value="available"
                                {{ old('status', $room->status ?? '') == 'available' ? 'selected' : '' }}>
                                متاح
                            </option>

                            <!-- الحالة: مشغول -->
                            <option value="occupied"
                                {{ old('status', $room->status ?? '') == 'occupied' ? 'selected' : '' }}>
                                مشغول
                            </option>

                            <!-- الحالة: تحت الصيانة -->
                            <option value="maintenance"
                                {{ old('status', $room->status ?? '') == 'maintenance' ? 'selected' : '' }}>
                                تحت الصيانة
                            </option>
                        </select>

                        @error('status')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="required form-label">Description</label>
                        <textarea name="overview" rows="4" class="form-control"
                                  required>{{ old('overview', $room->overview ?? '') }}</textarea>
                    </div>

                    <!-- Button to open modal -->
                    <div class="mb-3">
                        <label class="form-label d-block">Feature</label>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#detailModal">
                            Add Feature
                        </button>
                    </div>

                    <!-- Details List -->
                    <div id="detailsContainer" class="d-flex flex-column gap-3 mb-4">
                        @if(old('features'))
                            @foreach(old('features') as $key => $features)
                                <div class="card p-3 position-relative" data-id="{{ $key }}">
                                    <input type="hidden" name="features[{{ $key }}][name]" value="{{ $features['name'] }}">
                                    <input type="hidden" name="features[{{ $key }}][description]" value="{{ $features['description'] }}">
                                    <strong>Name:</strong> {{ $features['name'] }}<br>
                                    <strong>Description:</strong> {{ $features['description'] }}
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 remove-detail"></button>
                                </div>
                            @endforeach
                        @elseif(isset($room) && is_array($room->features))
                            @foreach($room->features as $key => $features)
                                <div class="card p-3 position-relative" data-id="{{ $key }}">
                                    <input type="hidden" name="features[{{ $key }}][name]" value="{{ $features['name'] }}">
                                    <input type="hidden" name="features[{{ $key }}][description]" value="{{ $features['description'] }}">
                                    <strong>Name:</strong> {{ $features['name'] }}<br>
                                    <strong>Description:</strong> {{ $features['description'] }}
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 remove-detail"></button>
                                </div>
                            @endforeach
                        @endif
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
                    <a href="{{ route('admin.rooms.index') }}" id="kt_ecommerce_add_product_cancel"
                       class="btn btn-light me-5 cancel">Cancel</a>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Add Features</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="detailName">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="detailDesc" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveDetail">Add</button>
                    <button type="button" class="btn btn-success d-none" id="updateDetail">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('admin/plugins/handleSubmitForm.js') }}"></script>
    <script>
        // تغيير الصورة وعرض المعاينة
        $(document).on('change', 'input[type="file"][name="images[]"]', function (e) {
            const input = this;
            const reader = new FileReader();

            reader.onload = function (e) {
                const imageInputWrapper = $(input).closest('.image-input').find('.image-input-wrapper');
                imageInputWrapper.css('background-image', 'url(' + e.target.result + ')');
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
{{--    <script src="{{ asset('admin/plugins/image-input.js') }}"></script>--}}

    <script>
        $(document).ready(function () {
            // إضافة عنصر جديد عند الضغط على زر إضافة
            $('[data-repeater-create]').on('click', function () {
                const repeaterList = $('[data-repeater-list]');
                const newItem = repeaterList.find('[data-repeater-item]').first().clone();

                // مسح القيم القديمة
                newItem.find('input[type="file"]').val('');
                newItem.find('input[name="id"]').val('');

                newItem.find('.image-input').removeClass('image-input-changed');
                newItem.find('.image-input').css('background-image', 'url("/admin_assets/media/svg/avatars/blank.svg")');

                // إضافة العنصر الجديد
                repeaterList.append(newItem);
            });

            // حذف العنصر عند الضغط على زر حذف
            $(document).on('click', '[data-repeater-delete]', function () {
                const $item = $(this).closest('[data-repeater-item]');
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "لن تتمكن من التراجع عن هذا!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'نعم، احذف!',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $item.remove();
                        Swal.fire(
                            'تم الحذف!',
                            'تم حذف الصورة بنجاح.',
                            'success'
                        );
                    }
                });
            });



            // زر "إزالة الصورة" يعيد الصورة الافتراضية
            $(document).on('click', '[data-kt-image-input-action="remove"]', function () {
                const container = $(this).closest('.image-input');
                container.find('input[type="file"]').val('');
                container.find('.image-input-wrapper').css('background-image', 'url({{ asset('admin_assets/media/svg/avatars/blank.svg') }})');
            });

            // زر "إلغاء التغيير" (يمكنك جعله يعمل مثل إزالة أو تجاهله حسب الحاجة)
            $(document).on('click', '[data-kt-image-input-action="cancel"]', function () {
                const container = $(this).closest('.image-input');
                container.find('input[type="file"]').val('');
                container.find('.image-input-wrapper').css('background-image', 'url({{ asset('admin_assets/media/svg/avatars/blank.svg') }})');
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const detailsContainer = document.getElementById('detailsContainer');
            let detailIndex = document.querySelectorAll('#detailsContainer .card').length;

            const modalEl = document.getElementById('detailModal');
            const modalTitle = document.getElementById('detailModalLabel');
            const detailNameInput = document.getElementById('detailName');
            const detailDescInput = document.getElementById('detailDesc');
            const saveBtn = document.getElementById('saveDetail');
            const updateBtn = document.getElementById('updateDetail');

            let currentEditId = null; // لتحديد إذا كنا نعدل

            // --- فتح المودال للإضافة ---
            document.querySelector('[data-bs-target="#detailModal"]').addEventListener('click', function () {
                modalTitle.textContent = 'Add Features';
                detailNameInput.value = '';
                detailDescInput.value = '';
                saveBtn.classList.remove('d-none');
                updateBtn.classList.add('d-none');
                currentEditId = null;
            });

            // --- حفظ تفصيل جديد ---
            saveBtn.addEventListener('click', function () {
                const name = detailNameInput.value.trim();
                const description = detailDescInput.value.trim();

                if (!name || !description) {
                    alert('Please fill out both name and description.');
                    return;
                }

                const detailHtml = `
                <div class="card p-3 position-relative" data-id="${detailIndex}">
                    <input type="hidden" name="features[${detailIndex}][name]" value="${name}">
                    <input type="hidden" name="features[${detailIndex}][description]" value="${description}">
                    <strong>Name:</strong> ${name}<br>
                    <strong>Description:</strong> ${description}
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 remove-detail"></button>
                </div>
            `;
                detailsContainer.insertAdjacentHTML('beforeend', detailHtml);
                detailIndex++;

                // إغلاق المودال
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();
            });

            // --- التعامل مع الحذف وفتح التعديل ---
            detailsContainer.addEventListener('click', function (e) {
                // حالة الضغط على زر الحذف
                if (e.target.classList.contains('remove-detail')) {
                    e.stopPropagation(); // منع انتشار الحدث لفتح المودال
                    const card = e.target.closest('.card');

                    // تأكيد الحذف عبر SweetAlert2
                    Swal.fire({
                        title: 'Are you sure you want to delete?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            card.remove();
                            Swal.fire(
                                'Deleted!',
                                'Detail has been deleted successfully.',
                                'success'
                            )
                        }
                    });
                    return; // منع تنفيذ باقي الكود
                }

                // حالة الضغط على البطاقة (غير زر الحذف) لفتح المودال
                if (e.target.closest('.card')) {
                    const card = e.target.closest('.card');
                    const name = card.querySelector('input[name*="[name]"]').value;
                    const description = card.querySelector('input[name*="[description]"]').value;
                    const id = card.dataset.id;

                    // تعبئة الحقول
                    detailNameInput.value = name;
                    detailDescInput.value = description;
                    modalTitle.textContent = 'Edit Detail';

                    // تغيير وضع الأزرار
                    saveBtn.classList.add('d-none');
                    updateBtn.classList.remove('d-none');

                    // تعيين الوضع للتعديل
                    currentEditId = id;

                    // فتح المودال
                    new bootstrap.Modal(modalEl).show();
                }
            });

            // --- تحديث التفصيل ---
            updateBtn.addEventListener('click', function () {
                const name = detailNameInput.value.trim();
                const description = detailDescInput.value.trim();

                if (!name || !description) {
                    alert('Please fill out both name and description.');
                    return;
                }

                const card = detailsContainer.querySelector(`.card[data-id="${currentEditId}"]`);
                if (card) {
                    card.innerHTML = `
                    <input type="hidden" name="features[${currentEditId}][name]" value="${name}">
                    <input type="hidden" name="features[${currentEditId}][description]" value="${description}">
                    <strong>Name:</strong> ${name}<br>
                    <strong>Description:</strong> ${description}
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 remove-detail"></button>
                `;
                }

                // إغلاق المودال
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
            });

            // --- تنظيف المودال عند الإغلاق ---
            modalEl.addEventListener('hidden.bs.modal', function () {
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style = '';

                // إعادة تعيين الحقول
                detailNameInput.value = '';
                detailDescInput.value = '';
                saveBtn.classList.remove('d-none');
                updateBtn.classList.add('d-none');
                currentEditId = null;
            });
        });
    </script>

@endpush
