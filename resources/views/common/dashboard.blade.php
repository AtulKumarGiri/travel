@extends('layouts.users.index')

@section('content')

<div class="container-fluid">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Welcome, {{ session('auth_user')->name }} 👋</h3>
            <small class="text-muted">
                {{ ucfirst(session('auth_user')->role) }} Dashboard
            </small>
        </div>
        <span class="badge bg-success text-uppercase">
            {{ session('auth_user')->status }}
        </span>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Bookings</h6>
                    <h3 class="mb-0">124</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Revenue</h6>
                    <h3 class="mb-0">₹ 3,25,000</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Pending Tasks</h6>
                    <h3 class="mb-0">7</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Notifications</h6>
                    <h3 class="mb-0">3</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Role Based Content -->
    @php $role = session('auth_user')->role; @endphp

    @if($role === 'admin')
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-dark text-white">
                Admin Controls
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Manage Users</li>
                    <li class="list-group-item">System Reports</li>
                    <li class="list-group-item">Settings & Permissions</li>
                </ul>
            </div>
        </div>

    @elseif($role === 'partner')
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                Partner Overview
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Manage Bookings</li>
                    <li class="list-group-item">View Payments</li>
                    <li class="list-group-item">Customer Requests</li>
                </ul>
            </div>
        </div>

    @elseif($role === 'supplier')
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-warning">
                Supplier Panel
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Inventory Status</li>
                    <li class="list-group-item">Delivery Schedule</li>
                </ul>
            </div>
        </div>

    @elseif($role === 'employee')
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-info text-white">
                Employee Workspace
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Assigned Tasks</li>
                    <li class="list-group-item">Submit Reports</li>
                    <li class="list-group-item">Attendance</li>
                </ul>
            </div>
        </div>

    @else
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-success text-white">
                Customer Dashboard
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">My Bookings</li>
                    <li class="list-group-item">Profile Settings</li>
                    <li class="list-group-item">Support Tickets</li>
                </ul>
            </div>
        </div>
    @endif

</div>

@endsection
