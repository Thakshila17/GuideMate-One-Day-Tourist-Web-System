<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuideMate Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="main-container">

        <div class="left-content">
            <h1>GuideMate</h1>
            <h3>One-Day Tourist Guide System</h3>
        </div>

        <div class="login-card">

            @php
                $showAdmin = $errors->admin->any() || old('login_type') == 'admin';
            @endphp

            {{-- TABS --}}
            <div class="tabs">
                <div class="tab {{ $showAdmin ? '' : 'active' }}" id="userTab">User</div>
                <div class="tab {{ $showAdmin ? 'active' : '' }}" id="adminTab">Admin</div>
            </div>

            {{-- USER LOGIN FORM --}}
            <form id="userForm" method="POST" action="{{ route('login.user') }}"
                @if ($showAdmin) style="display:none;" @endif>
                @csrf
                <input type="hidden" name="login_type" value="user">

                {{-- USER ERRORS --}}
                @if ($errors->user->any())
                    <div class="error-box">
                        @foreach ($errors->user->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <label>Username</label>
                <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>

                <label>Password</label>
                <div class="password-field">
                    <input type="password" name="password" placeholder="********" required>
                    <button type="button" class="password-toggle" aria-label="Show password"></button>
                    <a href="{{ route('user.password.reset') }}" class="forgot-link">Lost Password?</a>
                </div>

                <button class="btn">Sign In</button>

                <p class="signup-text">
                    Don't have an account?
                    <a href="{{ route('register') }}">Sign Up</a>
                </p>
            </form>

            {{-- ADMIN LOGIN FORM --}}
            <form id="adminForm" method="POST" action="{{ route('login.admin') }}"
                @if (!$showAdmin) style="display:none;" @endif>
                @csrf
                <input type="hidden" name="login_type" value="admin">

                {{-- ADMIN ERRORS --}}
                @if ($errors->admin->any())
                    <div class="error-box">
                        @foreach ($errors->admin->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <label>Admin Name</label>
                <input type="text" name="admin_name" placeholder="Enter admin name" value="{{ old('admin_name') }}"
                    required>

                <label>Password</label>
                <div class="password-field">
                    <input type="password" name="password" placeholder="********" required>
                    <button type="button" class="password-toggle" aria-label="Show password"></button>
                    <a href="{{ route('admin.password.reset') }}" class="forgot-link">Lost Password?</a>
                </div>

                <button class="btn">Admin Login</button>
            </form>

        </div>
    </div>

    {{-- SUCCESS TOAST MESSAGE- USER REGISTER --}}
    @if (session('status'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast custom-toast" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/login.js') }}"></script>
    <script src="{{ asset('js/password-toggle.js') }}"></script>
</body>

</html>
