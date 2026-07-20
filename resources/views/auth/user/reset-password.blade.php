<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}">
</head>

<body>
    <div class="main-container">
        <div class="left-content">
            <h1>GuideMate</h1>
            <h3>One-Day Tourist Guide System</h3>
        </div>
        <div class="login-card">
            <h2>Reset Password - User</h2>

            @if (session('status'))
                <div class="success-box">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('user.password.update') }}">
                @csrf

                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" value="{{ old('username') }}"
                    required>
                @error('username')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <label>New Password</label>
                <div class="password-field">
                    <input type="password" name="password" placeholder="Enter new password" required>
                    <button type="button" class="password-toggle" aria-label="Show password"></button>
                </div>
                @error('password')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <label>Confirm Password</label>
                <div class="password-field">
                    <input type="password" name="password_confirmation" placeholder="Confirm new password" required>
                    <button type="button" class="password-toggle" aria-label="Show password"></button>
                </div>
                @error('password_confirmation')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <button class="btn">Update Password</button>
            </form>

            <div class="auth-links">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/password-toggle.js') }}"></script>
</body>
</div>
</body>

</html>
