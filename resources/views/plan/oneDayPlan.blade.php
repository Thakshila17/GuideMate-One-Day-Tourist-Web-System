@extends('layouts.user-dashboard')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/oneDayPlan.css') }}">

    @if (session('status'))
        <div id="toast" class="toast {{ session('type') ?? 'success' }}">
            {{ session('status') }}
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showToast("{{ session('status') }}", "{{ session('type') ?? 'success' }}");
            });
        </script>
    @endif

    <div class="container">

        <div class="top-nav">
            <div class="nav-left">
                <h2>My One-Day Plan</h2>
            </div>

            <div class="nav-right">
                <div class="plan-count">
                    ({{ $plans->count() }}) Places Added
                </div>
            </div>
        </div>

        <div class="save-route">
            <div class="text">
                <h4>Discover the best order to visit your favorite places in one day.</h4>

                <button id="saveRouteBtn" class="saveRoute">Generate Route</button>
            </div>

            @if ($plans->count() > 0)
                <ul id="sortable">

                    @foreach ($plans as $plan)
                        @if ($plan->attraction)
                            <li class="plan-row" data-id="{{ $plan->id }}"
                                data-attraction-id="{{ $plan->attraction_id }}">

                                <div class="plan-left">
                                    <img src="{{ asset('storage/' . $plan->attraction->image) }}" alt="">

                                    <div class="plan-info">
                                        <div class="plan-order">
                                            Order: <span class="order-num">{{ $plan->visit_order }}</span>
                                        </div>

                                        <div class="plan-name">
                                            {{ $plan->attraction->name }}
                                        </div>

                                        <div class="plan-location">
                                            {{ $plan->attraction->location }}
                                        </div>

                                        @if (!$plan->attraction->lat || !$plan->attraction->lng)
                                            <div class="no-coords-warning">
                                                No coordinates — won't appear on map
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="plan-right">
                                    <form action="{{ route('plan.delete', $plan->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Remove</button>
                                    </form>
                                </div>

                            </li>
                        @endif
                    @endforeach

                </ul>
            @else
                <div class="no-plans">
                    <p>No places added to your one-day plan yet.</p>
                    <a href="{{ route('plan.view') }}" class="btn-go-dashboard">
                        Save Places →
                    </a>
                </div>
            @endif

        </div>

    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="{{ asset('js/oneDayPlan.js') }}"></script>
