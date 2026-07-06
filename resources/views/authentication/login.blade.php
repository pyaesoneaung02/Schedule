<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="icon" type="image/jfif" href="{{ asset('admin/img/icon.jfif') }}">

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="col-md-4">

        <!-- Title -->
        <div class="mb-4 text-center">
            <h3 class="fw-semibold">Welcome Back</h3>
            <p class="text-muted small">Login with your social account</p>
        </div>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <input type="email" class="form-control form-control-lg" placeholder="example@example.com" name="email" autocomplete="off" value="{{ old('email') }}">
                @error('email')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <input type="password" class="form-control form-control-lg" placeholder="Password" name="password" autocomplete="new-password">
                @error('password')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3 d-flex justify-content-between small">
                <div>
                    <input type="checkbox" class="form-check-input">
                    <label class="form-check-label ms-1">Remember</label>
                </div>
                <a href="#" class="text-decoration-none">Forgot?</a>
            </div>

            <button type="submit" class="py-2 mb-3 btn btn-primary w-100">
                Login
            </button>

        </form>

        <!-- Divider -->
        <div class="mb-3 text-center text-muted small">
            or continue with
        </div>

        <!-- Social Buttons -->
        {{-- <div class="gap-2 d-grid">

            <button class="btn btn-outline-danger">
                <i class="bi bi-google"></i> Continue with Google
            </button>

            <button class="btn btn-outline-primary">
                <i class="bi bi-facebook"></i> Continue with Facebook
            </button>

            <button class="btn btn-outline-dark">
                <i class="bi bi-github"></i> Continue with GitHub
            </button>

        </div> --}}

        <!-- Social Buttons -->
        <div class="gap-2 d-grid">

            <a href="{{ route('socialLogin','google') }}" class="btn btn-outline-danger">
                <i class="bi bi-google"></i> Continue with Google
            </a>

            {{--
            <a href="{{ route('facebook.redirect') }}" class="btn btn-outline-primary">
                <i class="bi bi-facebook"></i> Continue with Facebook
            </a>
            --}}

            <a href="{{ route('socialLogin','github') }}" class="btn btn-outline-dark">
                <i class="bi bi-github"></i> Continue with GitHub
            </a>

        </div>

        <!-- Signup -->
        <p class="mt-3 text-center small">
            Don’t have an account? <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a>
        </p>

    </div>

</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
