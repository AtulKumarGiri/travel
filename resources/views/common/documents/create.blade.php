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

            <div class="ms-3 d-flex align-items-center flex-row col-md-5" id="docTypeWrapper">
                <label class="form-label fw-bold col-md-5">Document Type: </label>
                <select class="form-select" id="docType">
                    <option value="General">General</option>
                    <option value="Travel Enquiry">Travel</option>
                    <option value="Invoice">Invoice</option>
                    <option value="Booking">Booking</option>
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
                <div class="col-md-3 mb-2">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" class="form-control" id="docTitle" placeholder="Document title">
                </div>

                <!-- Type -->
                

                <div id="shareUsersWrapper" class="d-none col-md-9 d-flex align-items-start mt-0">
                    <div class="col-md-4">
                        <label class="form-label fw-bold mb-1">Share With Employees</label>
    
                        <select id="shareUsers" class="form-select select2 multiple" multiple>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    @if(in_array($user->id, $selectedUsers ?? [])) selected @endif>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="userPermissions" class="mt-3 ms-4 col-md-6">
                        <!-- dynamically filled by JS -->
                    </div>
                    @include('layouts.other.permission')
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
