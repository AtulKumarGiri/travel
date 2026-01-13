@extends('layouts.users.index')

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">CMS Banners</h4>

        <a href="{{ route('cms.banner.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Banner
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
                        <th>Image</th>
                        <th>Heading</th>
                        <th>Subheading</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="18%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($banners as $banner)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                @if($banner->image)
                                    <img src="{{ asset('storage/'.$banner->image) }}" 
                                        alt="Banner Image" 
                                        class="img-thumbnail" 
                                        style="width: 100px; height: auto;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $banner->heading }}</strong>
                            </td>

                            <td>
                                {{ \Illuminate\Support\Str::limit($banner->subheading, 50, '...') }}

                            </td>

                            <td>
                                <span class="badge {{ $banner->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($banner->status) }}
                                </span>
                            </td>

                            <td>
                                {{ $banner->created_at->format('d M Y') }}
                            </td>

                            <td>
                                <!-- View (optional, can show full banner or carousel) -->
                                <a href="{{ route('cms.banner.show', $banner->id) }}" 
                                target="_blank" 
                                class="btn btn-sm btn-success" 
                                title="View">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('cms.banner.edit', $banner->id) }}" 
                                class="btn btn-sm btn-warning" 
                                title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('cms.banner.destroy', $banner->id) }}" 
                                    method="POST" 
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No banners found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


        </div>
    </div>

</div>
@endsection
