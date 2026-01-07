@extends('layouts.users.index')

@section('content')

{{-- Summernote CSS --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

<form action="{{ route('cms.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        Create CMS Page
    </div>

    <div class="card-body">

        <!-- Title -->
        <div class="mb-3">
            <label class="form-label fw-bold">Page Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <!-- Slug -->
        <div class="mb-3">
            <label class="form-label fw-bold">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" placeholder="auto-generated if empty">
            <small class="text-muted">URL preview: /<span id="slugPreview"></span></small>
        </div>


        <!-- Content -->
        <div class="mb-3">
            <label class="form-label fw-bold">Page Content</label>
            <textarea name="content" id="summernote" class="form-control"></textarea>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label class="form-label fw-bold">Featured Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <select name="status" class="form-select">
                <option value="draft">Draft</option>
                <option value="active">Active</option>
            </select>
        </div>

        <!-- Visibility -->
        <div class="mb-3">
            <label class="form-label fw-bold">Visibility</label>
            <select name="visibility" class="form-select">
                <option value="public">Public</option>
                <option value="private">Private</option>
                <option value="role">Role Based</option>
            </select>
        </div>

        <!-- Parent Page -->
        <div class="mb-3">
            <label class="form-label fw-bold">Parent Page</label>
            <select name="parent_id" class="form-select">
                <option value="">No Parent</option>
                @foreach($parents as $p)
                    <option value="{{ $p->id }}">{{ $p->title }}</option>
                @endforeach
            </select>
        </div>

    </div>

    <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">
            Save Page
        </button>
    </div>
</div>
</form>

{{-- Summernote JS --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function () {
    $('#summernote').summernote({
        height: 300,
        placeholder: 'Write page content here...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });

    let slugEdited = false;

    function generateSlug(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')   // remove special chars
            .replace(/\s+/g, '-')           // spaces to hyphens
            .replace(/-+/g, '-');           // remove multiple hyphens
    }

    // Generate slug while typing title
    $('#title').on('keyup', function () {
        if (!slugEdited) {
            let slug = generateSlug($(this).val());
            $('#slug').val(slug);
            $('#slugPreview').text(slug);
        }
    });

    // Detect manual slug edit
    $('#slug').on('keyup change', function () {
        slugEdited = true;
        $('#slugPreview').text($(this).val());
    });

});
</script>

@endsection
