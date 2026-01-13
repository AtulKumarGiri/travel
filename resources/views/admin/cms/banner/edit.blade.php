@extends('layouts.users.index')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">Edit Banner</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('cms.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Heading -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Heading</label>
                    <input type="text" name="heading" class="form-control" value="{{ old('heading', $banner->heading) }}" required>
                </div>

                <!-- Subheading -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Subheading</label>
                    <textarea name="subheading" class="form-control">{{ old('subheading', $banner->subheading) }}</textarea>
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Banner Image</label>
                    <input type="file" name="image" class="form-control">
                    @if($banner->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$banner->image) }}" alt="Banner Image" class="img-thumbnail" style="width: 200px;">
                        </div>
                    @endif
                    <small class="text-muted">Upload new image to replace the current one.</small>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ $banner->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="draft" {{ $banner->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">
                    Update Banner
                </button>
            </div>
        </div>
    </form>

</div>
@endsection
