<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/user-dashboard.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<div id="toast" class="toast"></div>

<body>
    <div class="container">

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-top">
                <div class="logo">
                    <h1>GuideMate</h1>
                    <p>One-Day Visit Planner</p>
                </div>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <span id="toggleIcon">«</span>
                </button>
            </div>

            <hr class="hr-top">

            <nav class="nav-links">
                <a href="{{ route('user.dashboard') }}"
                    class="{{ request()->is('user/dashboard') ? 'active' : '' }}">Explore
                    Attractions</a>

                <a href="{{ route('plan.view') }}" class="{{ request()->is('user/plans') ? 'active' : '' }}">Saved
                    Places</a>

                <a href="{{ route('plan.show-one-day-plan') }}"
                    class="{{ request()->is('plan/one-day-plan') ? 'active' : '' }}">Plan One-Day
                    Visit</a>

                <a href="{{ route('plan.generate-route') }}"
                    class="{{ request()->is('plan/generate-route') ? 'active' : '' }}">Generate
                    Route</a>

                <a href="{{ route('contact') }}">Contact Us</a>

            </nav>

            <hr class="hr-down">

            <div class="logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            @yield('content')
        </main>

    </div>

    <script src="{{ asset('js/user-dashboard.js') }}"></script>
</body>

</html>
