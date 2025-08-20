<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>الدفع الآمن - {{ $room->title }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- LineIcons for icons -->
    <link href="https://cdn.jsdelivr.net/npm/lineicons@3.0/dist/lineicons.css" rel="stylesheet">

    <!-- Stripe JS -->
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .account-login.section {
            padding: 40px 0;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
        }

        .order-summary-section .card-body p {
            margin-bottom: 0.5rem;
            font-size: 1rem;
            color: #495057;
        }

        #payment-element {
            margin: 1.5rem 0;
        }

        .btn-primary {
            padding: 12px 24px;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .alert {
            border-radius: 8px;
        }

        .lni-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="account-login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12">

                <!-- Order Summary -->
                <div class="order-summary-section mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="lni lni-calendar"></i> ملخص الحجز</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>الغرفة:</strong> {{ $room->title }}</p>
                            <p><strong>السعر لليلة:</strong> ${{ number_format($room->roomType->price_per_night, 2) }}</p>
                            <p><strong>تاريخ الوصول:</strong> {{ $data['check_in'] }}</p>
                            <p><strong>تاريخ المغادرة:</strong> {{ $data['check_out'] }}</p>
                            <p><strong>المجموع:</strong> <strong>$<span id="total-amount">جاري التحميل...</span></strong></p>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <div class="payment-section">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0"><i class="lni lni-credit-cards"></i> الدفع الآمن عبر Stripe</h4>
                        </div>
                        <div class="card-body">
                            <div id="payment-message" class="alert alert-info" style="display: none;"></div>
                            <form id="payment-form">
                                <div id="payment-element"></div>
                                <button type="submit" id="submit" class="btn btn-primary btn-lg w-100 mt-3">
                                    <span id="button-text"><i class="lni lni-lock-alt"></i> دفع <span id="pay-amount">$0.00</span></span>
                                    <span id="spinner" style="display: none;">
                                        <i class="lni lni-spinner lni-spin"></i> جاري المعالجة...
                                    </span>
                                </button>
                            </form>
                            <div class="text-center mt-3">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                    <i class="lni lni-arrow-left"></i> العودة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--//*******************في حالة كان انشاء الانتنت في صفحة الدفع نفسها *************************//--}}
{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function () {--}}
{{--        const stripe = Stripe("{{ config('services.stripe.publishable_key') }}");--}}

{{--        let elements;--}}
{{--        let clientSecret;--}}

{{--        initialize();--}}

{{--        document.querySelector("#payment-form").addEventListener("submit", handleSubmit);--}}

{{--        // إنشاء PaymentIntent واستلام clientSecret--}}
{{--        async function initialize() {--}}
{{--            try {--}}
{{--                const response = await fetch("{{ route('admin.payment.create', $room->id) }}", {--}}
{{--                    method: "POST",--}}
{{--                    headers: {--}}
{{--                        "Content-Type": "application/json",--}}
{{--                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')--}}
{{--                    },--}}
{{--                    body: JSON.stringify({})--}}
{{--                });--}}

{{--                const data = await response.json();--}}

{{--                if (data.error) {--}}
{{--                    showMessage(data.error, 'danger');--}}
{{--                    return;--}}
{{--                }--}}

{{--                clientSecret = data.clientSecret;--}}

{{--                // تحديث المبلغ في الواجهة--}}
{{--                if (data.amount) {--}}
{{--                    const formattedAmount = parseFloat(data.amount).toFixed(2);--}}
{{--                    document.getElementById('total-amount').textContent = formattedAmount;--}}
{{--                    document.getElementById('pay-amount').textContent = '$' + formattedAmount;--}}
{{--                }--}}

{{--                // إنشاء عناصر الدفع--}}
{{--                elements = stripe.elements({ clientSecret });--}}
{{--                const paymentElement = elements.create("payment");--}}
{{--                paymentElement.mount("#payment-element");--}}

{{--            } catch (error) {--}}
{{--                showMessage('فشل في تحميل طريقة الدفع. ' + error.message, 'danger');--}}
{{--            }--}}
{{--        }--}}

{{--        async function handleSubmit(e) {--}}
{{--            e.preventDefault();--}}
{{--            setLoading(true);--}}

{{--            const { error } = await stripe.confirmPayment({--}}
{{--                elements,--}}
{{--                confirmParams: {--}}
{{--                    return_url: "{{ route('admin.payment.success') }}",--}}
{{--                },--}}
{{--            });--}}

{{--            if (error) {--}}
{{--                showMessage(error.message, 'danger');--}}
{{--                setLoading(false);--}}
{{--            }--}}
{{--        }--}}

{{--        // عرض الرسائل--}}
{{--        function showMessage(message, type = 'info') {--}}
{{--            const messageEl = document.getElementById('payment-message');--}}
{{--            messageEl.className = `alert alert-${type}`;--}}
{{--            messageEl.textContent = message;--}}
{{--            messageEl.style.display = 'block';--}}

{{--            setTimeout(() => {--}}
{{--                messageEl.style.display = 'none';--}}
{{--            }, 5000);--}}
{{--        }--}}

{{--        // إدارة حالة الزر--}}
{{--        function setLoading(loading) {--}}
{{--            const submitBtn = document.getElementById('submit');--}}
{{--            const spinner = document.getElementById('spinner');--}}
{{--            const buttonText = document.getElementById('button-text');--}}

{{--            if (loading) {--}}
{{--                submitBtn.disabled = true;--}}
{{--                spinner.style.display = 'inline';--}}
{{--                buttonText.style.display = 'none';--}}
{{--            } else {--}}
{{--                submitBtn.disabled = false;--}}
{{--                spinner.style.display = 'none';--}}
{{--                buttonText.style.display = 'inline';--}}
{{--            }--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
{{--//*************في حال ان الانتنت تم انشاءها قبل التوجه ل صفحة الدفع وهذه هي حالتنا الان ***************//--}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stripe = Stripe("{{ config('services.stripe.publishable_key') }}");

        let elements;
        let clientSecret = "{{ $paymentIntent['client_secret'] }}"; // تم تمريره من الـ Controller
        const amount = {{ $paymentIntent['amount'] ?? 0 }}; // أو من $data إذا لم يكن في paymentIntent

        // تحديث الواجهة بالقيمة
        if (amount) {
            const formattedAmount = (amount / 100).toFixed(2); // إذا كان المبلغ بالسنتات
            document.getElementById('total-amount').textContent = formattedAmount;
            document.getElementById('pay-amount').textContent = '$' + formattedAmount;
        }

        // تهيئة Stripe Elements باستخدام clientSecret الموجود
        initialize();

        document.querySelector("#payment-form").addEventListener("submit", handleSubmit);

        async function initialize() {
            try {
                // استخدام clientSecret مباشرة بدون fetch
                elements = stripe.elements({ clientSecret: clientSecret });

                const paymentElement = elements.create("payment");
                paymentElement.mount("#payment-element");

            } catch (error) {
                showMessage('فشل في تحميل واجهة الدفع: ' + error.message, 'danger');
            }
        }

        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: "{{ route('admin.payment.success') }}",
                },
            });

            if (error) {
                showMessage(error.message, 'danger');
                setLoading(false);
            }
        }

        function showMessage(message, type = 'info') {
            const messageEl = document.getElementById('payment-message');
            messageEl.className = `alert alert-${type}`;
            messageEl.textContent = message;
            messageEl.style.display = 'block';

            setTimeout(() => {
                messageEl.style.display = 'none';
            }, 5000);
        }

        function setLoading(loading) {
            const submitBtn = document.getElementById('submit');
            const spinner = document.getElementById('spinner');
            const buttonText = document.getElementById('button-text');

            if (loading) {
                submitBtn.disabled = true;
                spinner.style.display = 'inline';
                buttonText.style.display = 'none';
            } else {
                submitBtn.disabled = false;
                spinner.style.display = 'none';
                buttonText.style.display = 'inline';
            }
        }
    });
</script>
</body>
</html>
