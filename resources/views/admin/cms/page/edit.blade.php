@extends('layouts.users.index')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

<form action="{{ route('cms.update', $page->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        Edit CMS Page
    </div>

    <div class="card-body">

        <!-- Title -->
        <div class="mb-3">
            <label class="form-label fw-bold">Page Title</label>
            <input type="text" id="title" name="title" value="{{ $page->title }}" class="form-control" required>
        </div>

        <!-- Slug -->
        <div class="mb-3">
            <label class="form-label fw-bold">Slug</label>
            <input type="text" id="slug" name="slug" value="{{ $page->slug }}" class="form-control">
        </div>

        <!-- Content -->
        <div class="mb-3">
            <label class="form-label fw-bold">Page Content</label>
            <textarea name="content" id="summernote" class="form-control">
                {!! $page->content !!}
            </textarea>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label class="form-label fw-bold">Featured Image</label>
            <input type="file" name="image" class="form-control">

            @if($page->image)
                <img src="{{ asset($page->image) }}" class="mt-2 rounded" width="120">
            @endif
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <select name="status" class="form-select">
                <option value="draft" {{ $page->status == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="active" {{ $page->status == 'active' ? 'selected' : '' }}>Active</option>
            </select>
        </div>

        <!-- Visibility -->
        <div class="mb-3">
            <label class="form-label fw-bold">Visibility</label>
            <select name="visibility" class="form-select">
                <option value="public" {{ $page->visibility == 'public' ? 'selected' : '' }}>Public</option>
                <option value="private" {{ $page->visibility == 'private' ? 'selected' : '' }}>Private</option>
                <option value="role" {{ $page->visibility == 'role' ? 'selected' : '' }}>Role Based</option>
            </select>
        </div>

        <!-- Parent -->
        <div class="mb-3">
            <label class="form-label fw-bold">Parent Page</label>
            <select name="parent_id" class="form-select">
                <option value="">No Parent</option>
                @foreach($parents as $p)
                    <option value="{{ $p->id }}"
                        {{ $page->parent_id == $p->id ? 'selected' : '' }}>
                        {{ $p->title }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>

    <div class="card-footer text-end">
        <a href="{{ route('cms.index') }}" class="btn btn-secondary">
            Cancel
        </a>
        <button type="submit" class="btn btn-primary">
            Update Page
        </button>
    </div>
</div>
</form>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function () {

    $('#summernote').summernote({
        height: 300
    });

    // Auto slug generation
    $('#title').on('keyup', function () {
        let slug = $(this).val()
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
        $('#slug').val(slug);
    });

});
</script>

@endsection
