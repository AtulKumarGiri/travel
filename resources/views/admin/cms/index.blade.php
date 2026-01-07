@extends('layouts.users.index')

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">CMS Pages</h4>

        <a href="{{ route('cms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Page
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- CMS Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover table-bordered mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Visibility</th>
                        <th>Parent</th>
                        <th>Created</th>
                        <th width="18%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong>{{ $page->title }}</strong>
                            </td>

                            <td>
                                <span class="text-muted">{{ $page->slug }}</span>
                            </td>

                            <td>
                                <span class="badge 
                                    {{ $page->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($page->status) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst($page->visibility) }}
                                </span>
                            </td>

                            <td>
                                {{ $page->parent?->title ?? '-' }}
                            </td>

                            <td>
                                {{ $page->created_at->format('d M Y') }}
                            </td>

                            <td>
                                <a href="{{ url('/'.$page->slug) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-success">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('cms.edit', $page->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('cms.destroy', $page->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this page?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No CMS pages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
