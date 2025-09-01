@extends('layouts.app')

@section('content')

<div class="container"> <div class="row justify-content-center"> <div class="col-md-8"> <div class="card enhanced-card"> <div class="card-header"> <h4>Edit Subject: {{ $subject->name }}</h4> </div>
text
            <div class="card-body">
                <form method="POST" action="{{ route('subjects.update', $subject) }}" class="enhanced-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $subject->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Subject Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $subject->code) }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $subject->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="teachers" class="form-label">Assign Teachers</label>
                        <select class="form-select @error('teachers') is-invalid @enderror" id="teachers" name="teachers[]" multiple size="5">
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ in_array($teacher->id, old('teachers', $subject->teachers->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple teachers</small>
                        @error('teachers')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assign to Classes</label>
                        <div class="row">
                            @foreach($classes as $class)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="classes[]" value="{{ $class->id }}" id="class{{ $class->id }}" {{ in_array($class->id, old('classes', $subject->classes->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="class{{ $class->id }}">{{ $class->name }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div> @endsection
