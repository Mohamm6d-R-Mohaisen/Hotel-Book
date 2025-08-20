"use strict";

// ===== إعدادات الداتاتابل العامة =====
window.DataTableConfig = {
    // الإعدادات الأساسية
    processing: true,
    serverSide: true,
    searchDelay: 500,           // تقليل التأخير في البحث
    pagingType: 'simple_numbers',
    ordering: false,
    searching: true,            // تفعيل البحث

    // اللغة العربية
    language: {
        lengthMenu: " _MENU_",
        info: " _END_Row From _TOTAL_",
        infoEmpty: "0 Row",
        infoFiltered: "(Filtered From _MAX_ Row)",
        paginate: {
            next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
            previous: '<i class="ri-arrow-left-s-line"></i>' // or '←'
        },
        emptyTable: "No data available in the table",
        zeroRecords: "No matching records found"
    },

    // هيكل DOM مع جميع العناصر على خط واحد
    dom: '<"row"<"col-sm-12"tr>>' +
         '<"row"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-4"i><"col-sm-12 col-md-4"p>>',

    // تحسينات الأداء
    initComplete: function() {
        const $wrapper = $(`#${this.sTableId}_wrapper`);

        // إضافة classes مرة واحدة فقط
        $wrapper.find('.dataTables_paginate .pagination').addClass('pagination-sm');
        $wrapper.find('.dataTables_length select').addClass('form-select form-select-sm');
        $wrapper.find('.dataTables_info').addClass('text-muted');
        $wrapper.find('table').addClass('table-hover');

        // ربط الأحداث بعد تهيئة الجدول (مهم جدًا!)
        $(document).off('change.active_status').on('change', '.active_operation', function() {
            window.toggleStatus('oc_datatable', this);
        });

        $(document).off('click.delete_row').on('click.delete_row', '[data-kt-docs-table-filter="delete_row"]', function(e) {
            e.preventDefault();
            const $button = $(this);
            const deleteUrl = $button.data('action');
            const recordId = $button.data('id');
            window.deleteRecord('oc_datatable', recordId, deleteUrl);
        });



        // ربط حقل البحث المباشر
        const searchInput = document.querySelector('[data-kt-docs-table-filter="search"]');
        if (searchInput && window.DataTables['oc_datatable']) {
            const table = window.DataTables['oc_datatable'];
            searchInput.addEventListener('keyup', function() {
                const searchValue = this.value;
                table.search(searchValue).draw();
            });
        }
    },

    // ربط AJAX
    ajax: {
        url: '', // سيتم تعديلها في `initDataTable`
        type: 'GET',
        data: function(d) {
            return d;
        },
        error: function(xhr) {
            console.error(`Error loading data:`, xhr.statusText);
        }
    },

    columns: [],
    columnDefs: []
};

// ===== متغيرات عامة =====
window.DataTables = {};

// ===== وظيفة تهيئة الداتا تابل =====
window.initDataTable = function(tableId, ajaxUrl, columns, columnDefs = [], customConfig = {}) {
    const $table = $(`#${tableId}`);

    // التحقق من وجود الجدول
    if ($table.length === 0) {
        console.error(`Table #${tableId} not found.`);
        return null;
    }

    // منع إعادة التهيئة
    if ($.fn.dataTable.isDataTable(`#${tableId}`)) {
        const oldTable = $table.DataTable();
        oldTable.destroy(); // تدمير الجدول القديم أولًا
        console.warn(`Old table #${tableId} destroyed.`);
    }

    // دمج الإعدادات
    const config = $.extend(true, {}, window.DataTableConfig, customConfig);

    // تحديث AJAX
    config.ajax.url = ajaxUrl;

    // إعداد الأعمدة
    config.columns = columns || [];
    if (columnDefs.length > 0) {
        config.columnDefs = columnDefs;
    }

    try {
        const table = $table.DataTable(config);
        window.DataTables[tableId] = table;

        // إنشاء دالة إعادة التحميل (باستخدام `false` لعدم إعادة تعيين الصفحة)
        const reloadFunctionName = `reload${tableId.charAt(0).toUpperCase()}${tableId.slice(1)}Table`;
        window[reloadFunctionName] = function() {
            table.ajax.reload(null, false); // ← لا يعيد تعيين الصفحة
        };

        console.log(`✅ Table initialized: #${tableId}`);
        return table;
    } catch (e) {
        console.error(`Failed to initialize table #${tableId}:`, e);
        return null;
    }
};

// ===== وظائف عامة =====

// إعادة تحميل الجدول (مُحسّن)
window.reloadTable = function(tableId) {
    const table = window.DataTables[tableId];
    if (table && $.fn.dataTable.isDataTable(table.settings().table())) {
        table.ajax.reload(null, false); // لا يعيد تعيين الصفحة
    }
};

// حذف عنصر
window.deleteRecord = function(tableId, recordId, deleteUrl) {
    Swal.fire({
        title: 'Are you sure?',
        text: `Are You Sure To Delete This Record ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-primary me-4',
            cancelButton: 'btn btn-outline-secondary ms-3'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE',
                    id: recordId
                },
                success: function(response) {
                    const msg = response.message || 'Deleted successfully';

                    Swal.fire({
                        title: 'Deleted!',
                        text: msg,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary me-4',         // ← زيادة المسافة
                            cancelButton: 'btn btn-outline-secondary ms-3' // ← مسافة من اليسار
                        },
                        buttonsStyling: false,
                        willOpen: () => {
                            const popup = Swal.getPopup();
                            if (popup) {
                                popup.style.gap = '1rem'; // ← مسافة جيدة بين الأزرار
                            }
                        }
                    });

                    window.reloadTable(tableId);
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || 'An error occurred while deleting';
                    Swal.fire({
                        title: 'Error!',
                        text: msg,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary me-4',         // ← زيادة المسافة
                            cancelButton: 'btn btn-outline-secondary ms-3' // ← مسافة من اليسار
                        },
                        buttonsStyling: false,
                        willOpen: () => {
                            const popup = Swal.getPopup();
                            if (popup) {
                                popup.style.gap = '1rem'; // ← مسافة جيدة بين الأزرار
                            }
                        }
                    });
                }
            });
        }
    });
};

// تبديل الحالة
window.toggleStatus = function(tableId, checkbox) {
    const $checkbox = $(checkbox);
    const url = $checkbox.data('url');
    const title = $checkbox.data('title') || 'Element';
    const currentStatus = $checkbox.data('current-status');
    const newStatus = currentStatus === 1 ? 0 : 1;
    const statusText = newStatus === 1 ? 'Active' : 'Inactive';

    const originalStatus = currentStatus;

    Swal.fire({
        title: 'Confirm Change?',
        text: `Are you sure you want to ${statusText} this element?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: statusText,
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-primary me-4',
            cancelButton: 'btn btn-outline-secondary ms-3'
        },
        buttonsStyling: false,
        willOpen: () => {
            const popup = Swal.getPopup();
            if (popup) {
                popup.style.gap = '1.5rem'; // مسافة جيدة
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $checkbox.prop('checked', newStatus === 1);
            $checkbox.data('current-status', newStatus);

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: newStatus
                },
                success: function(response) {
                    const msg = response.message || 'Status changed successfully';
                    Swal.fire({
                        title: 'Status Changed!',
                        text: msg,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        },
                        buttonsStyling: false
                    });
                    window.reloadTable(tableId);
                },
                error: function(xhr) {
                    $checkbox.prop('checked', originalStatus === 1);
                    $checkbox.data('current-status', originalStatus);

                    const msg = xhr.responseJSON?.message || 'An error occurred while changing the status';
                    Swal.fire({
                        title: 'Error!',
                        text: msg,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    });
                }
            });
        } else {
            $checkbox.prop('checked', originalStatus === 1);
            $checkbox.data('current-status', originalStatus);
        }
    });
};
// ===== التهيئة التلقائية =====
$(document).ready(function() {
    // التحقق من التبعيات
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded.');
        return;
    }
    if (typeof $.fn.DataTable === 'undefined') {
        console.error('DataTables is not loaded.');
        return;
    }

    // التهيئة التلقائية
    if ($('#oc_datatable').length > 0 && window.datatable_url && window.columns) {
        window.initDataTable(
            'oc_datatable',
            window.datatable_url,
            window.columns,
            window.columnDefs || [],
            window.datatableConfig || {}
        );
    }
});
