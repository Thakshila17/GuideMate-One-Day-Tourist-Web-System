@extends('layouts.admin-dashboard')

@section('content')
    <div class="page-header">
        <h2>Manage Categories</h2>
        <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addModal">
            + Add Category
        </button>
    </div>

    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Color</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $cat)
                    <tr>
                        <td>{{ $cat->name }}</td>
                        <td>
                            <span class="badge" style="background-color: {{ $cat->color }}">
                                {{ $cat->name }}
                            </span>
                        </td>
                        <td>{{ $cat->status }}</td>
                        <td class="action-btn">
                            <button class="edit-btn category" data-id="{{ $cat->id }}" data-name="{{ $cat->name }}"
                                data-color="{{ $cat->color }}" data-status="{{ $cat->status }}" data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                Edit
                            </button>

                            <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="delete-btn" type="submit">Delete</button>
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
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf

                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control name-input"
                                placeholder="Enter category name" required>
                        </div>

                        <div class="form-group">
                            <label>Color</label>
                            <input type="color" name="color" class="form-control form-control-color add-color"
                                value="#2d6a4f">
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
                        <button type="submit" class="btn save-btn">Save Category</button>
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
                        <h5 class="modal-title fw-bold">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="editName" class="form-control name-input" required>
                        </div>

                        <div class="form-group">
                            <label>Color</label>
                            <input type="color" name="color" id="editColor"
                                class="form-control form-control-color edit-color">
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
                        <button type="submit" class="btn save-btn">Update Category</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
