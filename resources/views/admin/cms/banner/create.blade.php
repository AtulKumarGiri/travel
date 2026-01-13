@extends('layouts.users.index')

@section('content')

<form action="{{ route('cms.banner.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Create Slider Banner
        </div>

        <div class="card-body">

            <div id="slidesContainer">
                <!-- Slide template -->
                <div class="slide-item border p-3 mb-3 position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 remove-slide" title="Remove Slide"></button>

                    <!-- Slide Image -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slide Image</label>
                        <input type="file" name="slides[0][image]" class="form-control" required>
                    </div>

                    <!-- Slide Heading -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slide Heading</label>
                        <input type="text" name="slides[0][heading]" class="form-control" placeholder="Slide Heading" required>
                    </div>

                    <!-- Slide Subheading -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slide Subheading / Description</label>
                        <textarea name="slides[0][subheading]" class="form-control" rows="3" placeholder="Slide description"></textarea>
                    </div>

                    <!-- Slide Status -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="slides[0][status]" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="active">Active</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="button" id="addSlide" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle me-1"></i> Add Slide
            </button>

        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Save Slider</button>
        </div>
    </div>

</form>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script>
$(document).ready(function () {

    let slideIndex = 1; // Start from 1 because first slide is 0

    // Add new slide
    $('#addSlide').on('click', function() {
        let slideTemplate = `
            <div class="slide-item border p-3 mb-3 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 remove-slide" title="Remove Slide"></button>

                <div class="mb-3">
                    <label class="form-label fw-bold">Slide Image</label>
                    <input type="file" name="slides[${slideIndex}][image]" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Slide Heading</label>
                    <input type="text" name="slides[${slideIndex}][heading]" class="form-control" placeholder="Slide Heading" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Slide Subheading / Description</label>
                    <textarea name="slides[${slideIndex}][subheading]" class="form-control" rows="3" placeholder="Slide description"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="slides[${slideIndex}][status]" class="form-select">
                        <option value="draft">Draft</option>
                        <option value="active">Active</option>
                    </select>
                </div>
            </div>
        `;
        $('#slidesContainer').append(slideTemplate);
        slideIndex++;
    });

    // Remove slide
    $(document).on('click', '.remove-slide', function() {
        $(this).closest('.slide-item').remove();
    });

});
</script>

@endsection
