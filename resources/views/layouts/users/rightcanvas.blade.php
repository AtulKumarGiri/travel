<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="notificationCanvas"
    aria-labelledby="notificationCanvasLabel"
>
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="notificationCanvasLabel">
            🔔 Notifications
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-0">
        <ul class="list-group list-group-flush">

            <li class="list-group-item">
                <strong>New Booking</strong>
                <p class="mb-0 text-muted small">
                    Booking #BK1023 has been created
                </p>
            </li>

            <li class="list-group-item">
                <strong>Payment Received</strong>
                <p class="mb-0 text-muted small">
                    ₹5,000 received from Partner
                </p>
            </li>

            <li class="list-group-item">
                <strong>Status Updated</strong>
                <p class="mb-0 text-muted small">
                    Your profile has been approved
                </p>
            </li>

            <!-- Empty State -->
            {{-- 
            <li class="list-group-item text-center text-muted py-4">
                No notifications
            </li> 
            --}}

        </ul>
    </div>
</div>
