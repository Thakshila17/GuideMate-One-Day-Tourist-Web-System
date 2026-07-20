@extends('layouts.user-dashboard')

@section('content')

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/route.css') }}">

    <div class="route-page-wrap">

        <div class="route-topbar">
            <div>
                <h2>My Route Plan</h2>
            </div>
            <a href="{{ route('plan.show-one-day-plan') }}" class="btn-back">← Back to Plan</a>
        </div>

        <div class="route-searchbar">
            <label for="townSelect">Start from:</label>

            <select id="townSelect">
                <option value="" disabled selected>— Select a town —</option>
                <option value="Veyangoda" data-lat="7.154417595312598" data-lng="80.05868102235864">Veyangoda</option>
                <option value="Minuwangoda" data-lat="7.169036145126043" data-lng="79.94806287550801">Minuwangoda</option>
                <option value="Naiwala" data-lat="7.158688519989422" data-lng="80.03162217245065">Naiwala</option>
                <option value="Nittambuwa" data-lat="7.143861516206506" data-lng="80.09558261117526">Nittambuwa</option>
                <option value="Udugampola" data-lat="7.125902699541903" data-lng="79.98126781707194">Udugampola</option>
                <option value="Dewalapola" data-lat="7.162550080200097" data-lng="80.00208722232291">Dewalapola</option>
                <option value="Bemmulla" data-lat="7.122442707757462" data-lng="80.02057159079214">Bemmulla</option>
            </select>

            <button class="btn-search" id="btnSearch" type="button">
                Search Route
            </button>

            <span class="search-status" id="searchStatus" style="display:none;"></span>
        </div>

        <div class="route-body">

            {{-- SIDEBAR --}}
            <aside class="route-sidebar">
                <div class="sidebar-inner">

                    @php
                        $missingCoords = $plans->filter(
                            fn($p) => !$p->attraction || !$p->attraction->lat || !$p->attraction->lng,
                        );
                    @endphp
                    @if ($missingCoords->count() > 0)
                        <div class="coords-warning">
                            Missing coordinates — skipped from map:
                            <ul>
                                @foreach ($missingCoords as $m)
                                    <li>{{ $m->attraction->name ?? 'Unknown' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- SUMMARY STATS --}}
                    <div class="route-summary" id="routeSummary" style="display:none;">
                        <div class="summary-row">
                            <span class="label">Stops</span>
                            <span class="value" id="statStops">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Distance</span>
                            <span class="value" id="statDist">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Travel Time</span>
                            <span class="value" id="statTime">—</span>
                        </div>
                        <div class="start-badge" id="startBadge"></div>
                    </div>

                    {{-- ROUTE LOADING STATE --}}
                    <div id="routeInfo">Choose your starting town above, then click Search Route.</div>

                    {{-- STOP LIST --}}
                    <h3>Stops</h3>
                    <ol class="stop-list" id="stopList">
                        @foreach ($plans as $i => $plan)
                            @if ($plan->attraction && $plan->attraction->lat && $plan->attraction->lng)
                                <li data-id="{{ $plan->attraction->id }}" data-lat="{{ $plan->attraction->lat }}"
                                    data-lng="{{ $plan->attraction->lng }}">
                                    <span class="stop-num">{{ $i + 1 }}</span>
                                    <span>
                                        <span class="stop-name">{{ $plan->attraction->name }}</span>
                                        <span class="stop-loc">{{ $plan->attraction->location ?? '' }}</span>
                                    </span>
                                </li>
                            @endif
                        @endforeach
                    </ol>

                    {{-- LEG DETAILS --}}
                    <div id="legDetails" class="leg-details"></div>

                </div>
            </aside>

            {{-- MAP --}}
            <div id="map"></div>

        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        window.placesData = @json($plans);
    </script>
    <script src="{{ asset('js/route.js') }}"></script>

@endsection
