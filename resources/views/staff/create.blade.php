@extends('layouts.app')

@section('title', 'Add New Staff')
@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('staff.index') }}" class="breadcrumb-link">Staff Management</a>
    </div>
    <div class="breadcrumb-item">
        <span class="breadcrumb-link">Add New Staff</span>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card enhanced-card">
                <div class="card-header">
                    <h4>Add New Staff Member</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('staff.store') }}" class="enhanced-form" enctype="multipart/form-data">
                        @csrf

                        <!-- Profile Picture Section -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="profile-picture-section">
                                    <div class="new-picture">
                                        <label for="profile_picture" class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control @error('profile_picture') is-invalid @enderror"
                                               id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <div class="form-text">Allowed formats: jpeg, png, jpg, gif. Max size: 2MB.</div>
                                        @error('profile_picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="picture-preview mt-3">
                                        <label class="form-label">Picture Preview</label>
                                        <div>
                                            <div id="noImagePreview" class="no-image-preview">
                                                <i class="fas fa-user fa-2x"></i>
                                                <p class="mt-2">No image selected</p>
                                            </div>
                                            <img id="imagePreview" class="profile-preview d-none" src="" alt="Preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="position" class="form-label">Position</label>
                                <select class="form-select @error('position') is-invalid @enderror"
                                        id="position" name="position" required>
                                    <option value="">Select Position</option>
                                    <option value="Administrator" {{ old('position') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                    <option value="Teacher" {{ old('position') == 'Teacher' ? 'selected' : '' }}>Teacher</option>
                                    <option value="Accountant" {{ old('position') == 'Accountant' ? 'selected' : '' }}>Accountant</option>
                                    <option value="Support Staff" {{ old('position') == 'Support Staff' ? 'selected' : '' }}>Support Staff</option>
                                </select>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control @error('department') is-invalid @enderror"
                                       id="department" name="department" value="{{ old('department') }}" required>
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="salary" class="form-label">Salary (UGX)</label>
                                <input type="number" step="0.01" class="form-control @error('salary') is-invalid @enderror"
                                       id="salary" name="salary" value="{{ old('salary') }}" placeholder="Enter amount">
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="hire_date" class="form-label">Hire Date</label>
                                <input type="date" class="form-control @error('hire_date') is-invalid @enderror"
                                       id="hire_date" name="hire_date" value="{{ old('hire_date') }}" required>
                                @error('hire_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('staff.index') }}" class="btn btn-secondary btn-enhanced">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-enhanced">
                                <i class="fas fa-save"></i> Add Staff
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-preview {
        width: 150px;
        height: 150px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #eaeaea;
    }

    .no-image-preview {
        width: 150px;
        height: 150px;
        border-radius: 8px;
        background: #f0f0f0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 2px dashed #ccc;
        text-align: center;
        padding: 10px;
    }

    .no-image-preview i {
        color: #999;
        margin-bottom: 5px;
    }

    .no-image-preview p {
        color: #777;
        font-size: 0.85rem;
        margin: 0;
    }

    .profile-picture-section {
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const profilePictureInput = document.getElementById('profile_picture');
        const imagePreview = document.getElementById('imagePreview');
        const noImagePreview = document.getElementById('noImagePreview');

        profilePictureInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    imagePreview.setAttribute('src', reader.result);
                    imagePreview.classList.remove('d-none');
                    noImagePreview.classList.add('d-none');
                });

                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('d-none');
                noImagePreview.classList.remove('d-none');
            }
        });
    });
</script>
@endsection
