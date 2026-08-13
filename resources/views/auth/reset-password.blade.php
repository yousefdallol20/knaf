<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إعادة تعيين كلمة المرور - منصة كنف</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
<body class="bg-warm d-flex flex-column" style="min-height: 100vh;">
    <main class="flex-grow-1 d-flex align-items-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border text-center">
                        <h3 class="fw-bold text-primary-green mb-3">تعيين كلمة مرور جديدة</h3>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3 text-start">
                                <label class="form-label text-small fw-semibold text-muted">البريد الإلكتروني</label>
                                <input type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" readonly required>
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label text-small fw-semibold text-muted">كلمة المرور الجديدة</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 text-start">
                                <label class="form-label text-small fw-semibold text-muted">تأكيد كلمة المرور</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">حفظ كلمة المرور الجديدة</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
