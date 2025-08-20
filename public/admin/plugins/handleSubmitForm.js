var CWSaveForm = function () {
    const init = () => {
        const form = document.getElementById('kt_form');
        const submitBtn = document.getElementById('kt_submit');

        if (!form || !submitBtn) return;

        submitBtn.addEventListener('click', e => {
            e.preventDefault();

            // حظر الزر + عرض الحالة
            const btnText = submitBtn.textContent;
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Saving...';

            // التحقق من الحقول الإلزامية
            let isValid = true;
            const required = form.querySelectorAll('[required]');

            required.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please fill all required fields',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: { confirmButton: 'btn btn-danger' },
                    buttonsStyling: false
                });
                resetButton();
                return;
            }

            // إرسال الطلب
            $.ajax({
                url: form.action,
                type: 'POST',
                data: new FormData(form),
                processData: false,
                contentType: false,
                success: (res) => {
                    resetButton();
                    if (res.status === 200 || res.status === 201) {
                        Swal.fire({
                            title: 'Saved!',
                            text: res.message || 'Saved successfully',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: { confirmButton: 'btn btn-success' },
                            buttonsStyling: false
                        }).then(() => {
                            if (res.redirect_url) {
                                window.location.href = res.redirect_url;
                            }
                            const redirect = form.getAttribute('data-kt-redirect');
                            if (redirect) window.location.href = redirect;
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: res.message || 'An error occurred',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            customClass: { confirmButton: 'btn btn-danger' },
                            buttonsStyling: false
                        });
                    }
                },
                error: (xhr) => {
                    resetButton();
                    let msg = 'An error occurred';
                    try {
                        const res = xhr.responseJSON;
                        if (res && res.message) msg = res.message;
                    } catch (e) {}
                    Swal.fire({
                        title: 'Error!',
                        text: msg,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: { confirmButton: 'btn btn-danger' },
                        buttonsStyling: false
                    });
                }
            });
        });

        // دالة إعادة الحالة للزر
        function resetButton() {
            const btn = document.getElementById('kt_submit');
            if (btn) {
                btn.removeAttribute('data-kt-indicator');
                btn.disabled = false;
                btn.textContent = 'Save';
            }
        }
    };

    return { init };
}();

// بدء التنفيذ
$(document).ready(CWSaveForm.init);
