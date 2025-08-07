@extends('layouts.app')

@section('title', 'Edit School Box Size Matrix')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0 fw-bold">Edit School Box Size Matrix</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.school-box-matrices.update', $boxMatrix) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="greater_than" class="form-label">Greater Than</label>
                            <input type="number" name="greater_than" id="greater_than" class="form-control" value="{{ old('greater_than', $boxMatrix->greater_than) }}" required min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="qty_of_env" class="form-label">Qty of Env</label>
                            <input type="number" name="qty_of_env" id="qty_of_env" class="form-control" value="{{ old('qty_of_env', $boxMatrix->qty_of_env) }}" required min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="box_style" class="form-label">Box Style</label>
                        <input type="text" name="box_style" id="box_style" class="form-control" value="{{ old('box_style', $boxMatrix->box_style) }}" required maxlength="10">
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="length" class="form-label">Length</label>
                            <input type="number" name="length" id="length" class="form-control" value="{{ old('length', $boxMatrix->length) }}" required min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="width" class="form-label">Width</label>
                            <input type="number" name="width" id="width" class="form-control" value="{{ old('width', $boxMatrix->width) }}" required min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="height" class="form-label">Height</label>
                            <input type="number" name="height" id="height" class="form-control" value="{{ old('height', $boxMatrix->height) }}" required min="1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="empty_box" class="form-label">Empty Box</label>
                            <input type="number" name="empty_box" id="empty_box" class="form-control" value="{{ old('empty_box', $boxMatrix->empty_box) }}" required min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" name="weight" id="weight" class="form-control" value="{{ old('weight', $boxMatrix->weight) }}" required min="0">
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger flex-fill">
                            <i class="bi bi-check-circle me-1"></i> Update Matrix
                        </button>
                        <a href="{{ route('admin.school-box-matrices') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 