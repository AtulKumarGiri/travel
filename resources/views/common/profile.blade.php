@extends('layouts.users.index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mx-auto">

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Profile</h5>

                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                            Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-pencil-square me-2"></i> Edit Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    <i class="bi bi-shield-lock me-2"></i> Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ $errors->first() }}
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Basic Info -->
                    <h6 class="text-primary border-bottom pb-2">Basic Information</h6>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Name</div>
                        <div class="col-md-8">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Email</div>
                        <div class="col-md-8">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Phone</div>
                        <div class="col-md-8">{{ $user->country_code }} {{ $user->mobile }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Role</div>
                        <div class="col-md-8 text-uppercase">{{ $user->role }}</div>
                    </div>

                    <!-- Professional Info -->
                    <h6 class="text-primary border-bottom pb-2 mt-4">Company Details</h6>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Batch Year</div>
                        <div class="col-md-8">{{ $user->batch_year }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Current Status</div>
                        <div class="col-md-8">{{ ucfirst($user->current_status) }}</div>
                    </div>

                    @if($user->current_status === 'working')
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Working Sector</div>
                            <div class="col-md-8">{{ $user->sector }}</div>
                        </div>
                    @endif

                    @if($user->current_status === 'studying')
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Field of Study</div>
                            <div class="col-md-8">{{ $user->field }}</div>
                        </div>
                    @endif

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Enrolled Subject</div>
                        <div class="col-md-8">{{ $user->enrolled_subject }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">President Name</div>
                        <div class="col-md-8">{{ $user->president_name }}</div>
                    </div>

                    <!-- Preferences -->
                    <!-- <h6 class="text-primary border-bottom pb-2 mt-4">Preffered Locations</h6>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Food Preference</div>
                        <div class="col-md-8">
                            <span class="badge bg-info text-dark">
                                {{ ucfirst($user->food_preference) }}
                            </span>
                        </div>
                    </div> -->

                    <!-- Account Info -->
                    <h6 class="text-primary border-bottom pb-2 mt-4">Account Details</h6>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Account Status</div>
                        <div class="col-md-8">
                            <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }} text-uppercase">
                                {{ $user->status }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Account Created</div>
                        <div class="col-md-8">
                            {{ $user->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Last Updated</div>
                        <div class="col-md-8">
                            {{ $user->updated_at->format('d M Y, h:i A') }}
                        </div>
                    </div>

                    

                </div>

                <!-- <div class="card-footer text-end">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        Edit Profile
                    </a>
                    <a href="{{ route('password.change') }}" class="btn btn-warning">
                        Change Password
                    </a>
                </div> -->
            </div>

        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('password.update') }}" class="modal-content">
            @csrf

            <div class="modal-header bg-warning">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label fw-bold">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">New Password</label>
                    <input type="password" name="new_password" class="form-control" required minlength="6">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-warning fw-bold">
                    Update Password
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
