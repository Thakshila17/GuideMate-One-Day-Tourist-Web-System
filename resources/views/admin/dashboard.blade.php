@extends('layouts.admin-dashboard')

@section('content')
    <div class="stats-grid">

        <div class="stat-card">
            <h4>Total Categories</h4>
            <h2>{{ $totalCategories }}</h2>
            <h5>{{ $activeCategories }} Active</h5>
        </div>

        <div class="stat-card">
            <h4>Total Attractions</h4>
            <h2>{{ $totalAttractions }}</h2>
            <h5>{{ $activeAttractions }} Active</h5>
        </div>

    </div>


    <div class="table-card">
        <h3>Latest Attractions</h3>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($latestAttractions as $a)
                    <tr>
                        <td>{{ $a->name }}</td>

                        <td>
                            <span class="badge" style="background-color: {{ $a->category->color ?? '#ccc' }}">
                                {{ $a->category->name ?? '-' }}
                            </span>
                        </td>

                        <td>{{ $a->location ?? '-' }}</td>

                        <td>
                            <span class="badge"
                                style="background-color: {{ $a->status == 'active' ? '#52b788' : '#bc4a4a' }}">
                                {{ $a->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            No attractions found
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
@endsection
