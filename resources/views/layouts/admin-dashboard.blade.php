<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
</head>

<body data-toast="{{ session('success') }}">

    <div class="container">

        {{-- SIDEBAR --}}
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-top">
                <div class="logo">
                    <h1>GuideMate</h1>
                    <p>Admin Panel</p>
                </div>

                <button class="sidebar-toggle" id="sidebarToggle">
                    <span id="toggleIcon">«</span>
                </button>
            </div>

            <hr class="hr-top">

            <nav class="nav-links">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <p>MANAGE</p>
                <a href="{{ route('admin.categories.index') }}"
                    class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                    Categories
                </a>

                <a href="{{ route('admin.attractions.index') }}"
                    class="{{ request()->is('admin/attractions*') ? 'active' : '' }}">
                    Attractions
                </a>
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

            {{-- CONTENT --}}
            <div class="content-section">
                @yield('content')
            </div>

        </main>

    </div>

    <div id="successToast" class="success-toast">
        <span id="toastMessage"></span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/user-dashboard.js') }}"></script>
    <script src="{{ asset('js/admin-dashboard.js') }}"></script>

</body>

</html>
