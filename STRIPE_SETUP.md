# إعداد Stripe للدفع

## المتطلبات الأساسية

1. حساب Stripe نشط
2. مفاتيح API من Stripe

## الخطوات

### 1. الحصول على مفاتيح Stripe

1. اذهب إلى [Stripe Dashboard](https://dashboard.stripe.com/)
2. انتقل إلى Developers > API keys
3. انسخ المفاتيح التالية:
   - Publishable key
   - Secret key

### 2. إعداد ملف .env

أضف المفاتيح التالية إلى ملف `.env`:

```env
STRIPE_KEY=pk_test_your_publishable_key_here
STRIPE_SECRET=sk_test_your_secret_key_here
STRIPE_CURRENCY=usd
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
```

### 3. إعداد Webhook (اختياري)

إذا كنت تريد معالجة أحداث الدفع تلقائياً:

1. في Stripe Dashboard، اذهب إلى Developers > Webhooks
2. أضف endpoint جديد: `https://yourdomain.com/admin/webhook/stripe`
3. اختر الأحداث التالية:
   - `payment_intent.succeeded`
   - `payment_intent.payment_failed`
4. انسخ Webhook secret وأضفه إلى `.env`

### 4. اختبار الدفع

1. تأكد من أن التطبيق يعمل
2. جرب إنشاء حجز جديد
3. تأكد من أن صفحة الدفع تظهر بشكل صحيح
4. استخدم بطاقة اختبار Stripe:
   - رقم البطاقة: `4242 4242 4242 4242`
   - تاريخ الانتهاء: أي تاريخ مستقبلي
   - CVC: أي 3 أرقام

## استكشاف الأخطاء

### مشكلة: صفحة الدفع لا تظهر

1. تحقق من مفاتيح Stripe في `.env`
2. تحقق من سجلات الخطأ في `storage/logs/laravel.log`
3. تأكد من أن `config/services.php` يحتوي على الإعدادات الصحيحة
4. تحقق من أن المسار `admin.bookings.payment.page` موجود

### مشكلة: خطأ في API

1. تحقق من أن مفاتيح Stripe صحيحة
2. تأكد من أن الحساب نشط
3. تحقق من حدود API

### مشكلة: الدفع لا يتم معالجته

1. تحقق من إعدادات Webhook
2. تأكد من أن `processPayment` يعمل بشكل صحيح
3. تحقق من سجلات الخطأ

### مشكلة: خطأ 302 (Redirect)

1. تحقق من أن `PaymentIntent` يتم إنشاؤه بنجاح
2. تحقق من أن البيانات تُخزن في الجلسة بشكل صحيح
3. تحقق من أن المسار صحيح

## ملاحظات مهمة

- استخدم مفاتيح الاختبار للتطوير
- استخدم مفاتيح الإنتاج للإنتاج
- احتفظ بمفاتيحك آمنة ولا تشاركها
- راجع [Stripe Documentation](https://stripe.com/docs) للمزيد من المعلومات

## التدفق الصحيح

1. **إنشاء الحجز** → `store()` method
2. **فحص توفر الغرفة** → `checkRoomAvailability()`
3. **حساب المبلغ** → حساب عدد الليالي × سعر الليلة
4. **إنشاء PaymentIntent** → `createPaymentIntent()`
5. **تخزين البيانات في الجلسة** → `session()`
6. **التوجيه إلى صفحة الدفع** → `showPaymentPage()`
7. **معالجة الدفع** → `processPayment()`
8. **إنشاء الحجز النهائي** → `createBooking()` 