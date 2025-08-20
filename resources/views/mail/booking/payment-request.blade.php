
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد الحجز - إتمام الدفع</title>
    <style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            direction: rtl;
            text-align: right;
        }
        .container {
    max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
    margin: 0;
    font-size: 28px;
            font-weight: 300;
        }
        .content {
    padding: 40px 30px;
        }
        .booking-details {
    background-color: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            margin: 20px 0;
            border-right: 4px solid #667eea;
        }
        .detail-row {
    display: flex;
    justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dotted #dee2e6;
        }
        .detail-row:last-child {
    border-bottom: none;
            margin-bottom: 0;
        }
        .detail-label {
    font-weight: 600;
            color: #495057;
        }
        .detail-value {
    color: #212529;
    font-weight: 500;
        }
        .total-amount {
    background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 25px 0;
        }
        .payment-button {
    text-align: center;
            margin: 30px 0;
        }
        .paypal-btn {
    display: inline-block;
    background: #0070ba;
    color: white;
    padding: 15px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0, 112, 186, 0.3);
            transition: all 0.3s ease;
        }
        .paypal-btn:hover {
    background: #005ea6;
    transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 112, 186, 0.4);
        }
        .security-notice {
    background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .security-notice h3 {
    color: #155724;
    margin: 0 0 10px 0;
            font-size: 16px;
        }
        .security-notice ul {
    margin: 10px 0 0 20px;
            color: #155724;
        }
        .security-notice li {
    margin-bottom: 8px;
        }
        .warning {
    background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .warning p {
    margin: 0;
    color: #856404;
    font-weight: 600;
        }
        .footer {
    background-color: #343a40;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .contact-info {
    margin: 15px 0;
        }
        .contact-info p {
    margin: 5px 0;
            color: #ced4da;
        }
        .icon {
    width: 20px;
            height: 20px;
            display: inline-block;
            margin-left: 8px;
            vertical-align: middle;
        }
        @media (max-width: 600px) {
    .container {
        margin: 10px;
                border-radius: 5px;
            }
            .content {
        padding: 20px 15px;
            }
            .header {
        padding: 20px 15px;
            }
            .header h1 {
        font-size: 24px;
            }
            .detail-row {
        flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏨 تأكيد حجز الفندق</h1>
            <p>مرحباً {{ $booking->guest_name }}</p>
</div>

<div class="content">
    <h2>تفاصيل الحجز</h2>

    <div class="booking-details">
        <div class="detail-row">
            <span class="detail-label">📋 رقم الحجز:</span>
            <span class="detail-value">{{ $booking->booking_reference }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">🏠 رقم الغرفة:</span>
            <span class="detail-value">{{ $booking->room->room_number ?? 'غير محدد' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">📅 تاريخ الوصول:</span>
            <span class="detail-value">{{ $booking->check_in->format('d/m/Y') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">📅 تاريخ المغادرة:</span>
            <span class="detail-value">{{ $booking->check_out->format('d/m/Y') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">🌙 عدد الليالي:</span>
            <span class="detail-value">{{ $booking->nights }} {{ $booking->nights == 1 ? 'ليلة' : 'ليالي' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">👤 اسم النزيل:</span>
            <span class="detail-value">{{ $booking->guest_name }}</span>
        </div>
    </div>

    <div class="total-amount">
        💰 المبلغ الإجمالي: ${{ number_format($booking->total_amount, 2) }}
    </div>

    <div class="payment-button">
        <a href="{{ $paypalLink }}" class="paypal-btn">
            🔒 ادفع الآن عبر PayPal
        </a>
    </div>

    <div class="security-notice">
        <h3>🛡️ معلومات الأمان:</h3>
        <ul>
            <li>✅ الدفع آمن ومحمي بتشفير SSL</li>
            <li>✅ يمكنك الدفع بالبطاقة الائتمانية أو حساب PayPal</li>
            <li>✅ ستصلك رسالة تأكيد فور إتمام الدفع</li>
            <li>✅ معلوماتك المالية محمية بالكامل</li>
        </ul>
    </div>

    <div class="warning">
        <p>⏰ يرجى إتمام الدفع خلال 24 ساعة لضمان الحجز</p>
    </div>

    <p>في حالة وجود أي استفسارات أو مشاكل في عملية الدفع، يرجى عدم التردد في التواصل معنا.</p>

    <p>نتطلع لاستضافتك قريباً! 🌟</p>
</div>

<div class="footer">
    <h3>معلومات التواصل</h3>
    <div class="contact-info">
        <p>📧 البريد الإلكتروني: info@yourhotel.com</p>
        <p>📱 الهاتف: +1-555-0123</p>
        <p>🌐 الموقع الإلكتروني: www.yourhotel.com</p>
        <p>📍 العنوان: شارع الفندق، المدينة، البلد</p>
    </div>
    <p style="margin-top: 20px; font-size: 14px; color: #6c757d;">
        {{ config('app.name') }} © {{ date('Y') }}
    </p>
    <p style="font-size: 12px; color: #6c757d; margin-top: 10px;">
        هذه رسالة تلقائية، يرجى عدم الرد على هذا البريد الإلكتروني
    </p>
</div>
</div>
</body>
</html>
