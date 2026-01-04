@extends('layouts.front.index')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">

                    <h4 class="text-center mb-4">Login</h4>

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <!-- Role -->
                        <div class="mb-3">
                            <label class="form-label">Login As</label>
                            <select
                                name="role"
                                class="form-select {{ $errors->has('role') ? 'is-invalid' : '' }}"
                                data-bs-toggle="popover"
                                data-bs-trigger="focus"
                                data-bs-placement="right"
                                data-bs-content="{{ $errors->first('role') }}"
                            >
                                <option value="">-- Select Role --</option>
                                <option value="admin">Admin</option>
                                <option value="partner">Partner</option>
                                <option value="supplier">Supplier</option>
                                <option value="customer">Customer</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ old('email') }}"
                                data-bs-toggle="popover"
                                data-bs-trigger="focus"
                                data-bs-placement="right"
                                data-bs-content="{{ $errors->first('email') }}"
                            >
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                data-bs-toggle="popover"
                                data-bs-trigger="focus"
                                data-bs-placement="right"
                                data-bs-content="{{ $errors->first('password') }}"
                            >
                        </div>

                        <!-- Account Status / Other Errors -->
                        @if($errors->has('status'))
                            <div class="alert alert-danger py-2 text-center">
                                {{ $errors->first('status') }}
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100">
                            Login
                        </button>

                        <div class="text-center mt-3">
                            <small>
                                Don't have an account?
                                <a href="{{ route('register') }}">Register</a>
                            </small>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap Popover Init --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const popoverTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="popover"]')
        );

        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        // Auto-show popovers if error exists
        document.querySelectorAll('.is-invalid').forEach(el => {
            let popover = bootstrap.Popover.getInstance(el);
            if (popover) {
                popover.show();
            }
        });
    });
</script>
@endsection
