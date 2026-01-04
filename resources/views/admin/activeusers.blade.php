<div class="offcanvas offcanvas-end" tabindex="-1" id="activeUsersCanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">
            Active Users
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-0">
        <ul class="list-group list-group-flush">
            @forelse($activeUsers ?? [] as $user)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $user->name }}</strong><br>
                        <small class="text-muted text-uppercase">{{ $user->role }}</small>
                    </div>
                    <span class="badge bg-success">Online</span>
                </li>
            @empty
                <li class="list-group-item text-center text-muted">
                    No active users
                </li>
            @endforelse
        </ul>
    </div>
</div>
