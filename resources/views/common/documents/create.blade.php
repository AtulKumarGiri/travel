@extends('layouts.users.index')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-1">
        <div class="d-flex justify-content-start align-items-center col-md-8">
            <h4 class="col-md-3">Create Document</h4>
            <div class="btn-group privacy-toggle ms-3 col-md-4" role="group" id="privacyToggle">
                <input type="radio" class="btn-check" name="privacyOptions" id="privacyPrivate" value="private" checked>
                <label class="btn privacy-btn" for="privacyPrivate">Private</label>

                <input type="radio" class="btn-check" name="privacyOptions" id="privacyShared" value="shared">
                <label class="btn privacy-btn" for="privacyShared">Shared</label>
                <div id="privacyStatus" class="privacy-status ms-2"></div>
            </div>


            <div id="shareUsersWrapper" class="ms-3 d-none col-md-6">
                <select id="shareUsers" class="form-select form-select-sm" multiple>
                    <option selected disabled>Share With Employees...</option>
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center col-md-3">
            <!-- Status -->
            <div id="autosaveStatus" class="small text-muted ms-4">
                <i class="bi bi-arrow-repeat"></i>
                Auto-save enabled...
            </div>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-sm ms-4">Back</a>
            

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row align-items-center mb-1">

                <!-- Title -->
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" class="form-control" id="docTitle" placeholder="Document title">
                </div>

                <!-- Type -->
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-bold">Type</label>
                    <select class="form-select" id="docType">
                        <option value="general">General</option>
                        <option value="travel">Travel</option>
                        <option value="invoice">Invoice</option>
                        <option value="booking">Booking</option>
                    </select>
                </div>

            </div>

            <!-- Description -->
            <div class="mb-2">
                <label class="form-label fw-bold">Description</label>
                <textarea id="docDescription" placeholder="Write details..."></textarea>
            </div>

            <!-- Footer / Submit -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
                <button class="btn btn-primary ms-2" id="saveDocument">Save Document</button>        
            </div>

        </div>
    </div>

</div>

@endsection
