@extends('layouts.users.index')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Documents</h4>
    <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">+ Add Document</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Type</th>
            <th>Created By</th>
            <th>Updated By</th>
            <th>Shared</th>
            <th>Last Updated</th>
            <th width="120">Action</th>
        </tr>
    </thead>

    <tbody class="text-center">
        @forelse($documents as $key => $doc)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $doc->title }}</td>
            <td class="text-capitalize">{{ $doc->type }}</td>
            <td>{{ $doc->creator->name ?? 'Unknown' }}</td>
            <td>{{ $doc->updater->name ?? 'Unknown' }}</td>
            <td>
                @if($doc->shared_with == 1)
                    <span class="badge bg-info">Yes</span>
                @else
                    <span class="badge bg-secondary">No</span>
                @endif
            </td>
            <td>{{ $doc->updated_at->format('d M Y h:i A') }}</td>
            <td class="text-center">

                {{-- VIEW BUTTON AS ICON --}}
                <a href="{{ route('documents.show', $doc->id) }}" 
                class="btn btn-sm btn-primary" 
                title="View Document">
                    <i class="bi bi-eye fs-6"></i>

                </a>

                {{-- EDIT BUTTON IF SAME USER --}}
                @if($doc->created_by == session('auth_user')->id)
                    <a href="{{ route('documents.edit', $doc->id) }}"
                    class="btn btn-sm btn-warning"
                    title="Edit Document">
                        <i class="bi bi-pencil-square fs-6"></i>
                    </a>
                @endif

            </td>

        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center text-muted">No Documents Found</td>
        </tr>
        @endforelse
    </tbody>

</table>

@endsection
