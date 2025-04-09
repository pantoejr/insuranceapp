<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ env('APP_NAME') }} | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="{{ env('APP_NAME') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/overlayscrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
</head>

<body class="login-page bg-body-secondary app-loaded">
    <div class="login-box">
        <div class="text-center mb-3">
            <img src="{{ asset('assets/images/VfPHgMS4ndKGxFSTrjGZDZqL5kpgXpnj2hTAZ8vn.png') }}" alt="Application Logo"
                width="220">
        </div>
        <div class="card border-0 shadow-sm rounded">
            <div class="card-body login-card-body rounded">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="{{ route('authenticate') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input id="loginEmail" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" placeholder="Email" required>
                            <label for="loginEmail">Email</label>
                        </div>
                        <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input id="loginPassword" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Password" required>
                            <label for="loginPassword">Password</label>
                        </div>
                        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                    </div>
                </form>
                <p class="mb-1 text-center"><a href="{{ route('password.request') }}" class="text-decoration-none">I
                        forgot my password</a></p>
                <div class="g-recaptcha mt-4" data-sitekey={{ config('services.recaptcha.key') }}></div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/overlayscrollbars.browser.es6.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
</body>

</html>
