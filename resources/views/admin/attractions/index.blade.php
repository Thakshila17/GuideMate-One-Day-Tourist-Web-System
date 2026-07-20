@extends('layouts.admin-dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/admin-attraction.css') }}">
    <div class="page-header">
        <h2>Manage Attractions</h2>

        <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addModal">
            + Add Attraction
        </button>
    </div>

    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.attractions.index') }}">
            <select name="category_id" onchange="this.form.submit()" class="category-filter">

                <option value="">All Categories</option>

                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach

            </select>
        </form>
    </div>

    <div class="attraction-table">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Opening Hours</th>
                    <th>Closing Hours</th>
                    <th>Entry Fee</th>
                    <th>Contact Info</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($attractions as $a)
                    <tr>
                        <td>{{ $a->name }}</td>

                        <td>
                            <span class="badge" style="background-color: {{ $a->category->color ?? '#ccc' }}">
                                {{ $a->category->name ?? '-' }}
                            </span>
                        </td>

                        <td>{{ $a->location }}</td>

                        <td>{{ $a->opening_hours ?? '-' }}</td>

                        <td>{{ $a->closing_hours ?? '-' }}</td>

                        <td>{{ $a->entry_fee ?? '-' }}</td>

                        <td>{{ $a->contact_info ?? '-' }}</td>

                        <td>
                            <span class="badge" style="background: {{ $a->status == 'active' ? '#52b788' : '#bc4a4a' }}">
                                {{ $a->status }}
                            </span>
                        </td>

                        <td class="action-btn">
                            <button class="edit-btn attraction" data-id="{{ $a->id }}"
                                data-name="{{ $a->name }}" data-image="{{ $a->image }}"
                                data-category="{{ $a->category_id }}" data-location="{{ $a->location }}"
                                data-description="{{ $a->description }}" data-lat="{{ $a->lat }}"
                                data-lng="{{ $a->lng }}" data-opening="{{ $a->opening_hours }}"
                                data-closing="{{ $a->closing_hours }}" data-fee="{{ $a->entry_fee }}"
                                data-contact="{{ $a->contact_info }}" data-status="{{ $a->status }}"
                                data-bs-toggle="modal" data-bs-target="#editModal">
                                Edit
                            </button>

                            <form method="POST" action="{{ route('admin.attractions.destroy', $a->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="delete-btn" type="submit">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    {{-- ================= ADD MODAL ================= --}}
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content add-modal">

                <form method="POST" action="{{ route('admin.attractions.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Add Attraction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control name-input" required>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" class="form-control status-input" required>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control name-input"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control name-input" required>
                        </div>

                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="text" name="lat" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" name="lng" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Opening Hours</label>
                            <input type="time" name="opening_hours" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Closing Hours</label>
                            <input type="time" name="closing_hours" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Entry Fee</label>
                            <input type="number" name="entry_fee" step="0.01">
                        </div>

                        <div class="form-group">
                            <label>Contact Info</label>
                            <input type="text" name="contact_info" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control status-input">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer border-0">
                        <button type="submit" class="btn save-btn">Save Attraction</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    {{-- ================= EDIT MODAL ================= --}}
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content edit-modal">

                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Edit Attraction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="editName" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" id="editCategory" class="form-control status-input">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" id="editLocation" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="editDescription" class="form-control name-input"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="text" name="lat" id="editLat" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" name="lng" id="editLng" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Opening Hours</label>
                            <input type="time" name="opening_hours" id="editOpening" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Closing Hours</label>
                            <input type="time" name="closing_hours" id="editClosing" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Entry Fee</label>
                            <input type="text" name="entry_fee" id="editFee" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Contact Info</label>
                            <input type="text" name="contact_info" id="editContact" class="form-control name-input">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="editStatus" class="form-control status-input">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer border-0">
                        <button type="submit" class="btn save-btn">Update Attraction</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
