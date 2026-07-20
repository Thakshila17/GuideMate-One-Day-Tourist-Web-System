<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}">
</head>

<body>
    <div class="main-container">
        <div class="left-content">
            <h1>GuideMate</h1>
            <h3>One-Day Tourist Guide System</h3>
        </div>
        <div class="login-card">
            <h2>Reset Password - Admin</h2>

            @if(session('status'))
            <div class="success-box">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf

                <label>Admin Name</label>
                <input type="text" name="admin_name" placeholder="Enter your admin name" value="{{ old('admin_name') }}" required>
                @error('admin_name')
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

</html>