@extends('layouts.user-dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/savePlace.css') }}">

    @if (session('status'))
        <script>
            window.LaravelToast = {
                message: "{{ session('status') }}",
                type: "{{ session('type') ?? 'success' }}"
            };
        </script>
    @endif

    <div class="top-nav">
        <div class="nav-left">
            <h2>My Saved Places</h2>
        </div>

        <div class="nav-right">
            <div class="plan-count">
                ({{ $plans->count() }}) Places Saved
            </div>
        </div>
    </div>

    <div class="text">
        <h4>Manage your saved places and add them to your one-day visit plan.</h4>
    </div>

    @forelse($plans as $plan)
        @if ($plan->attraction)
            <div class="plan-row">

                <div class="plan-left">
                    <img src="{{ asset('storage/' . $plan->attraction->image) }}" alt="">
                    <div class="plan-info">
                        <div class="plan-name">{{ $plan->attraction->name }}</div>
                        <div class="plan-date">
                            Saved on: {{ $plan->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <div class="plan-right">

                    {{-- DELETE --}}
                    <form action="{{ route('plan.delete', $plan->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            Delete
                        </button>
                    </form>

                    {{-- ADD --}}
                    <form action="{{ route('plan.add-to-one-day-plan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="place_id" value="{{ $plan->attraction_id }}">
                        <button type="submit" class="btn-add">
                            + Add to Plan
                        </button>
                    </form>

                    <a href="{{ route('plan.show-one-day-plan') }}" class="btn-go-day-plan">
                        Show Plan
                    </a>

                </div>

            </div>
        @endif

    @empty

        <div class="no-plans">
            <p>No saved places yet.</p>
            <a href="{{ route('user.dashboard') }}" class="btn-go-dashboard">
                Explore Places →
            </a>
        </div>
    @endforelse


    <script src="{{ asset('js/savePlace.js') }}"></script>
@endsection
