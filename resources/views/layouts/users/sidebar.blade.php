<style>
    .sidebar-module > a {
        padding: 8px 10px;
        border-radius: 6px;
        transition: 0.2s ease;
        font-weight: 500;
        font-size: 14px;
        color: #e9ecef;
        text-decoration: none;
    }

    .sidebar-module > a:hover {
        background: rgba(255,255,255,0.08);
        color: #fff;
    }

    .sidebar-module ul a {
        font-size: 13px;
        color: #d8d8d8;
        padding: 6px 8px;
        border-radius: 6px;
        text-decoration: none;
    }

    .sidebar-module ul a:hover {
        background: rgba(255,255,255,0.06);
        color: #fff;
    }

    .module-title {
        font-size: 11px;
        letter-spacing: .5px;
        color: #a0a0a0;
        text-transform: uppercase;
        margin-top: 14px;
        margin-bottom: 5px;
    }

    .collapse.show {
        background: rgba(255,255,255,0.04);
        border-radius: 6px;
        padding: 4px 0;
    }

    /* Arrow Rotate */
    .rotate-arrow.collapsed i {
        transform: rotate(0deg);
    }

    .rotate-arrow i {
        transition: transform .2s;
        transform: rotate(180deg);
    }
</style>


<ul class="nav flex-column p-3 bg-dark text-white vh-100">

    <li class="nav-item mb-2">
        <a class="nav-link fw-bold text-white" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
    </li>

    @php $role = session('auth_user')->role ?? '' @endphp

    <!-- SALES -->
    @if(in_array($role, ['admin','partner','user']))
    <div class="module-title">Sales & Booking</div>
    <li class="nav-item sidebar-module">
        <a class="d-flex justify-content-between align-items-center rotate-arrow collapsed"
           data-bs-toggle="collapse"
           href="#salesModule">
            <span><i class="bi bi-cart-check me-2"></i> Sales</span>
            <i class="bi bi-chevron-down small"></i>
        </a>
        <ul class="collapse ps-4" id="salesModule">
            <li><a href="#">Manage Bookings</a></li>
            @if(in_array($role, ['admin','partner']))
            <li><a href="#">Payments</a></li>
            @endif
        </ul>
    </li>
    @endif


    <!-- OPERATIONS -->
    @if(in_array($role, ['admin','supplier']))
    <div class="module-title">Operations</div>
    <li class="nav-item sidebar-module">
        <a class="d-flex justify-content-between align-items-center rotate-arrow collapsed"
            data-bs-toggle="collapse"
            href="#operationsModule">
            <span><i class="bi bi-box-seam me-2"></i> Packages</span>
            <i class="bi bi-chevron-down small"></i>
        </a>
        <ul class="collapse ps-4" id="operationsModule">
            <li><a href="#">Accomodation</a></li>
            <li><a href="#">Activities</a></li>
            <li><a href="#">Category</a></li>
            <li><a href="#">Country</a></li>
            <li><a href="#">City</a></li>
            <li><a href="#">Confirmation Days</a></li>
            <li><a href="#">Currency</a></li>
            <li><a href="#">Guide</a></li>
            <li><a href="#">Language</a></li>
            <li><a href="#">Meal Plan</a></li>
            <li><a href="#">Packages</a></li>
            <li><a href="#">Preferences</a></li>
            <li><a href="#">Refund Days</a></li>
            <li><a href="#">Transfer Type</a></li>
        </ul>
    </li>
    @endif


    <!-- EMPLOYEE -->
    @if(in_array($role, ['admin','employee']))
    <div class="module-title">Employee</div>
    <li class="nav-item sidebar-module">
        <a class="d-flex justify-content-between align-items-center rotate-arrow collapsed"
            data-bs-toggle="collapse"
            href="#employeeModule">
            <span><i class="bi bi-briefcase me-2"></i> Work</span>
            <i class="bi bi-chevron-down small"></i>
        </a>
        <ul class="collapse ps-4" id="employeeModule">
            <li><a href="#">Tasks</a></li>
            <li><a href="{{ route('documents.index') }}">Documents</a></li>
            <li><a href="#">Reports</a></li>
        </ul>
    </li>
    @endif


    <!-- ADMIN -->
    @if($role === 'admin')
    <div class="module-title">Admin</div>
    <li class="nav-item sidebar-module">
        <a class="d-flex justify-content-between align-items-center rotate-arrow collapsed"
            data-bs-toggle="collapse"
            href="#adminModule">
            <span><i class="bi bi-gear me-2"></i> Settings</span>
            <i class="bi bi-chevron-down small"></i>
        </a>
        <ul class="collapse ps-4" id="adminModule">
            <li><a href="#">CMS</a></li>
            <li><a href="#">Manage Users</a></li>
            <li><a href="#">System Reports</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </li>
    @endif

</ul>
