<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Register</title>
    <link rel="stylesheet" href="{{ asset('css/user-register.css') }}">
</head>

<body>

    <div class="main-container">

        <!-- LEFT CARD -->
        <div class="login-card">
            <h2>Create Account</h2>

            @if(session('status'))
            <div class="success-box">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('user.register') }}">
                @csrf

                <label>User Name</label>
                <input type="text" name="username" placeholder="Enter your user name" value="{{ old('username') }}" required>
                @error('username')
                <div class="field-error">{{ $message }}</div>
                @enderror

                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                @error('email')
                <div class="field-error">{{ $message }}</div>
                @enderror

                <label>Password</label>
                <div class="password-field">
                    <input type="password" name="password" placeholder="Enter password" required>
                    <button type="button" class="password-toggle" aria-label="Show password"></button>
                </div>
                @error('password')
                <div class="field-error">{{ $message }}</div>
                @enderror

                <label>Confirm Password</label>
                <div class="password-field">
                    <input type="password" name="password_confirmation" placeholder="Confirm password" required>
                    <button type="button" class="password-toggle" aria-label="Show password"></button>
                </div>
                @error('password_confirmation')
                <div class="field-error">{{ $message }}</div>
                @enderror

                <button class="btn">Register</button>
            </form>

            <div class="auth-links">
                <a href="{{ route('login') }}">Already have an account? Login</a>
            </div>
        </div>

        <script src="{{ asset('js/password-toggle.js') }}"></script>

        <!-- RIGHT SIDE -->
        <div class="right-content">
            <h1>GuideMate</h1>
            <h3>One-Day Tourist Guide System</h3>
        </div>
    </div>

</body>

</html>