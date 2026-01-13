@extends('layouts.users.index')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">{{ $document->title }}</h4>

            {{-- BADGES BELOW TITLE --}}
            <div class="mt-1">
                <span class="badge bg-info text-dark">{{ ucfirst($document->type) }}</span>

                @if($document->is_private)
                    <span class="badge bg-danger">Private</span>
                @else
                    <span class="badge bg-success">Shared</span>
                @endif
            </div>
        </div>
        <div>
            @if($document->created_by == session('auth_user')->id)
                <a href="{{ route('documents.edit', $document->id) }}"
                class="btn btn-sm btn-warning"
                title="Edit Document">
                    <i class="bi bi-pencil-square fs-6"></i>
                </a>
            @endif

            <a href="{{ route('documents.print', $document->id) }}"
            class="btn btn-sm btn-success"
            title="Print / Download PDF"
            target="_blank">
            <i class="bi bi-printer fs-6"></i>
            </a>

            <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-sm">
                Back
            </a>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="document-body">
                {!! $document->body !!}
            </div>

        </div>
    </div>

</div>

@endsection
