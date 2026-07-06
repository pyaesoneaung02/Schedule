<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" type="image/jfif" href="{{ asset('admin/img/icon.jfif') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <!-- Title -->
            <div class="mb-4 text-center">
                <h3 class="fw-semibold">Create Account</h3>
                <p class="text-muted small">Register with your social account</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Full Name"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control form-control-lg"
                        placeholder="example@example.com" autocomplete="off" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" name="phone" class="form-control form-control-lg" placeholder="Phone Number"
                        value="{{ old('phone') }}">
                    @error('phone')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password"
                        autocomplete="new-password">
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="password" name="password_confirmation" class="form-control form-control-lg"
                        placeholder="Confirm Password" autocomplete="new-password">
                    @error('password_confirmation')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 small">
                    <input type="checkbox" class="form-check-input">
                    <label class="form-check-label ms-1">
                        I agree to the terms & conditions
                    </label>
                </div>

                <button type="submit" class="py-2 mb-3 btn btn-success w-100">
                    Create Account
                </button>

            </form>

            <!-- Divider -->
            <div class="mb-3 text-center text-muted small">
                or sign up with
            </div>

            <!-- Social Buttons -->
            <!-- <div class="gap-2 d-grid">

            <button class="btn btn-outline-danger">
                <i class="bi bi-google"></i> Continue with Google
            </button>

            <button class="btn btn-outline-primary">
                <i class="bi bi-facebook"></i> Continue with Facebook
            </button>

            <button class="btn btn-outline-dark">
                <i class="bi bi-github"></i> Continue with GitHub
            </button>

        </div>-->

            <!-- Login Link -->
            <p class="mt-3 text-center small">
                Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
            </p>

        </div>

    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
