@extends('layouts.user-dashboard')

@section('content')
    <div class="top-nav">
        <h1>Welcome!</h1>
        <form method="GET" action="{{ route('user.dashboard') }}">
            <input type="text" name="search" placeholder="Search place..." value="{{ request('search') }}">
            <button type="submit">Search</button>
        </form>
    </div>

    {{-- TOAST MESSAGE --}}
    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast("{{ session('status') }}", "{{ session('type', 'success') }}");
            });
        </script>
    @endif

    {{-- HERO BAND --}}
    <div class="dashboard-hero">
        <h1>Explore <em>Attractions</em></h1>
        <p>Discover the best places to visit and build your One-Day Plan perfectly...</p>
    </div>

    <div class="content-section">

        {{-- CATEGORY BAR --}}
        <div class="category-bar">
            <button class="all-btn active" onclick="filterCategory('all', event)">All</button>

            @foreach ($categories as $cat)
                <button class="category-btn" style="background-color: {{ e($cat->color) }}"
                    onclick="filterCategory('{{ e($cat->name) }}', event)">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>

        {{-- PLACE CARDS --}}
        <div class="places-grid">
            @foreach ($attractions as $place)
                <div class="place-card" data-id="{{ $place->id }}" data-name="{{ e($place->name) }}"
                    data-image="{{ asset('storage/' . $place->image) }}"
                    data-category="{{ e($place->category->name ?? '') }}" data-description="{{ e($place->description) }}"
                    data-opening_hours="{{ e($place->opening_hours) }}"
                    data-closing_hours="{{ e($place->closing_hours) }}" data-entry_fee="{{ e($place->entry_fee) }}"
                    data-contact_info="{{ e($place->contact_info) }}" data-location="{{ e($place->location) }}">

                    <img src="{{ asset('storage/' . $place->image) }}" alt="{{ e($place->name) }}" loading="lazy">

                    <h3>{{ $place->name }}</h3>
                    <p>{{ Str::limit($place->description, 80) }}</p>
                </div>
            @endforeach
        </div>

    </div>

    {{-- MODAL --}}
    <div id="placeModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content">

            <div class="modal-header">
                <img id="modalImage" class="modal-img" alt="">
            </div>

            <div class="modal-body">
                <h2 id="modalTitle"></h2>
                <p class="category" id="modalCategory"></p>
                <p id="modalDesc"></p>

                <div class="info-grid">
                    <div class="info-box">
                        <p>Hours</p>
                        <strong id="modalHours"></strong>
                    </div>
                    <div class="info-box">
                        <p>Entry Fee</p>
                        <strong id="modalFee"></strong>
                    </div>
                    <div class="info-box">
                        <p>Contact</p>
                        <strong id="modalContact"></strong>
                    </div>
                    <div class="info-box">
                        <p>Location</p>
                        <strong id="modalLocation"></strong>
                    </div>
                </div>

                <div class="modal-actions">
                    <button class="plan-btn" id="addToPlanBtn">Save Plan</button>
                    <button class="close-btn" onclick="closeModal()">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection
