<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuideMate Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="main-container">

        <!-- LEFT TEXT -->
        <div class="left-content">
            <h1>GuideMate</h1>
            <h3>One-Day Tourist Guide System</h3>
        </div>

        <!-- LOGIN CARD -->
        <div class="login-card">

            @if(session('status'))
            <div class="success-box">{{ session('status') }}</div>
            @endif

            @php
            $showAdmin = $errors->admin->any() || old('login_type') == 'admin';
            @endphp

            <!-- TABS -->
            <div class="tabs">
                <div class="tab {{ $showAdmin ? '' : 'active' }}" id="userTab">User</div>
                <div class="tab {{ $showAdmin ? 'active' : '' }}" id="adminTab">Admin</div>
            </div>

            <!-- USER LOGIN FORM -->
            <form id="userForm" method="POST" action="{{ route('login.user') }}"
                @if($showAdmin) style="display:none;" @endif>
                @csrf
                <input type="hidden" name="login_type" value="user">

                <!-- User Errors -->
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

            <!-- ADMIN LOGIN FORM -->
            <form id="adminForm" method="POST" action="{{ route('login.admin') }}"
                @if(!$showAdmin) style="display:none;" @endif>
                @csrf
                <input type="hidden" name="login_type" value="admin">

                <!-- Admin Errors -->
                @if ($errors->admin->any())
                <div class="error-box">
                    @foreach ($errors->admin->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <label>Admin Name</label>
                <input type="text" name="admin_name" placeholder="Enter admin name" value="{{ old('admin_name') }}" required>

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

    <script src="{{ asset('js/login.js') }}"></script>
    <script src="{{ asset('js/password-toggle.js') }}"></script>
</body>

</html>