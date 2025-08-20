<div class="container mt-5">
    <div class="alert alert-danger text-center">
        <h2>❌ فشل الدفع</h2>
        <p>{{ $error }}</p>
        <a href="{{ url()->previous() }}" class="btn btn-warning">المحاولة مرة أخرى</a>
    </div>
</div>
