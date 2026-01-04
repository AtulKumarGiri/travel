@extends('layouts.front.index')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">

                    <h4 class="text-center mb-4">
                        Create Account
                    </h4>

                    <form method="POST" action="#">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Enter your full name"
                                   required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="Enter your email"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mobile Number</label>

                            <div class="input-group">
                                <select name="country_code" class="form-select" style="max-width: 120px;" required>
                                    <option value="+91" selected>🇮🇳 +91</option>
                                    <option value="+1">🇺🇸 +1</option>
                                    <option value="+44">🇬🇧 +44</option>
                                    <option value="+61">🇦🇺 +61</option>
                                    <option value="+971">🇦🇪 +971</option>
                                </select>

                                <input type="tel"
                                    name="mobile"
                                    class="form-control"
                                    placeholder="Enter mobile number"
                                    pattern="[0-9]{6,15}"
                                    required>
                            </div>
                        </div>


                        
                        <div class="mb-3">
                            <label class="form-label">Password</label>

                            <div class="input-group">
                                <input type="password"
                                    id="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Create a password"
                                    required>

                                <span class="input-group-text" style="cursor:pointer"
                                    onclick="togglePassword()">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                        </div>


                        <!-- Location -->
                        <div class="mb-4">
                            <label class="form-label">Location</label>
                            <input type="text"
                                   name="location"
                                   class="form-control"
                                   placeholder="City / State"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Register
                        </button>

                        <div class="text-center mt-3">
                            <small>
                                Already have an account?
                                <a href="{{ route('login') }}">Login</a>
                            </small>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = event.currentTarget.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
    document.querySelector('form').addEventListener('submit', function () {
        const code = document.querySelector('[name="country_code"]').value;
        const mobile = document.querySelector('[name="mobile"]').value;
        document.querySelector('[name="mobile"]').value = code + mobile;
    });
</script>
