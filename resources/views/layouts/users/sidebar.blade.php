<ul class="nav flex-column p-3">
    <li class="nav-item mb-2">
        <a class="nav-link fw-bold" href="{{ route('dashboard') }}">Dashboard Home</a>
    </li>

    @php $role = session('auth_user')->role ?? '' @endphp

    @if($role === 'admin')
        <li class="nav-item"><a class="nav-link" href="#">Manage Users</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
    @elseif($role === 'partner')
        <li class="nav-item"><a class="nav-link" href="#">Manage Bookings</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Payments</a></li>
    @elseif($role === 'supplier')
        <li class="nav-item"><a class="nav-link" href="#">Inventory</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Deliveries</a></li>
    @elseif($role === 'employee')
        <li class="nav-item"><a class="nav-link" href="#">Tasks</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
    @else
        <li class="nav-item"><a class="nav-link" href="#">My Bookings</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
    @endif
</ul>
