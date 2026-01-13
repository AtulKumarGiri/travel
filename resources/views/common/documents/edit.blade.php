@extends('layouts.users.index')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-1">

        <div class="d-flex justify-content-start align-items-center col-md-8">
            <h4 class="col-md-3">Edit Document</h4>

            {{-- Privacy Toggle --}}
            <div class="btn-group privacy-toggle ms-3 col-md-4" role="group" id="privacyToggle">
                <input type="radio" class="btn-check" name="privacyOptions" id="privacyPrivate" value="private"
                    {{ $document->is_private == '1' ? 'checked' : '' }}>
                <label class="btn privacy-btn" for="privacyPrivate">Private</label>

                <input type="radio" class="btn-check" name="privacyOptions" id="privacyShared" value="shared"
                    {{ $document->is_private == '0' ? 'checked' : '' }}>
                <label class="btn privacy-btn" for="privacyShared">Shared</label>
                <div id="privacyStatus" class="privacy-status ms-2"></div>
            </div>

            {{-- Shared Users --}}
            <div id="shareUsersWrapper"
                class="ms-3 col-md-6 {{ $document->privacy == 'shared' ? '' : 'd-none' }}">
                <select id="shareUsers" class="form-select form-select-sm" multiple>
                    <option disabled>Select Employees...</option>
                    @if($document->shared_with == '0')
                        @php 
                            $sharedUsers = $document->shared_with == 0 ? $document->sharedUsers : collect();
                        @endphp
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ in_array($user->id, $sharedUsers->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        {{-- Right side --}}
        <div class="d-flex justify-content-between align-items-center col-md-3">
            <div id="autosaveStatus" class="small text-muted ms-4">
                <i class="bi bi-arrow-repeat"></i>
                Auto-save enabled...
            </div>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-sm ms-4">Back</a>
        </div>

    </div>


    {{-- Document Card --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row align-items-center mb-1">
                {{-- Title --}}
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" class="form-control" id="docTitle"
                        value="{{ $document->title }}" placeholder="Document title">
                </div>

                {{-- Type --}}
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-bold">Type</label>
                    <select class="form-select" id="docType">
                        <option value="general" {{ $document->type=='general'?'selected':'' }}>General</option>
                        <option value="travel" {{ $document->type=='travel'?'selected':'' }}>Travel</option>
                        <option value="invoice" {{ $document->type=='invoice'?'selected':'' }}>Invoice</option>
                        <option value="booking" {{ $document->type=='booking'?'selected':'' }}>Booking</option>
                    </select>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-2">
                <label class="form-label fw-bold">Description</label>
                <textarea id="docDescription" class="form-control" rows="6"
                    placeholder="Write details...">{{ $document->body }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-end">
                <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
                <button class="btn btn-primary ms-2" id="saveDocument" data-id="{{ $document->id }}">
                    Save Document
                </button>
            </div>
        </div>
    </div>

</div>

@endsection
