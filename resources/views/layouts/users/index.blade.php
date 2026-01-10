<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Travel Management System') }} - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="d-flex flex-column vh-100">

    @include('layouts.users.header')

    <div class="d-flex flex-fill">
        <div id="sidebar" class="bg-light border-end sidebar-fixed">
            @include('layouts.users.sidebar')
        </div>

        <main id="main-content" class="flex-fill p-4">
            @yield('content')
        </main>
        <div>
            @include('layouts.users.rightcanvas')
        </div>
        <div>
            @include('admin.activeusers')
        </div>
        <div>
            @include('layouts.other.confirmation')
        </div>
    </div>

    <!-- Inactivity Warning Modal -->
    <div class="modal fade" id="inactivityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Session Expiring
                    </h5>
                </div>

                <div class="modal-body text-center">
                    <p class="mb-2">
                        You have been inactive for a while.
                    </p>
                    <p class="fw-bold text-danger mb-0">
                        Logging out in <span id="logoutCountdown">60</span> seconds
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ================= Sidebar Toggle =================
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const icon = document.getElementById('sidebarIcon');

            if(toggleBtn && sidebar && mainContent && icon){
                toggleBtn.addEventListener('click', () => {
                    const isCollapsed = sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');

                    // Toggle icon
                    if (isCollapsed) {
                        icon.classList.remove('bi-list');
                        icon.classList.add('bi-x-lg');
                    } else {
                        icon.classList.remove('bi-x-lg');
                        icon.classList.add('bi-list');
                    }
                });
            }

            // ================= Active Users Canvas =================
            const activeCanvas = document.getElementById('activeUsersCanvas');
            if(activeCanvas){
                activeCanvas.addEventListener('show.bs.offcanvas', function () {
                    document.querySelector('.bi-people-fill').closest('button').classList.add('btn-success');
                });
                activeCanvas.addEventListener('hidden.bs.offcanvas', function () {
                    document.querySelector('.bi-people-fill').closest('button').classList.remove('btn-success');
                });
            }

            // ================= Live Date/Time =================
            function updateLiveDateTime() {
                const now = new Date();
                const options = {
                    weekday: 'short', year: 'numeric', month: 'short', day: '2-digit',
                    hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true
                };
                const dtEl = document.getElementById('liveDateTime');
                if(dtEl) dtEl.innerText = now.toLocaleString('en-IN', options);
            }
            updateLiveDateTime();
            setInterval(updateLiveDateTime, 1000);

            // ================= Inactivity Logout =================
            let inactivityTimer, warningTimer, countdownTimer;
            const logoutAfter = 10*60*1000;   // 10 minutes
            const warningAfter = 9*60*1000;   // 9 minutes
            let countdownSeconds = 60;

            const inactivityModalEl = document.getElementById('inactivityModal');
            const inactivityModal = inactivityModalEl ? new bootstrap.Modal(inactivityModalEl, {backdrop:'static', keyboard:false}) : null;

            function resetTimers(){
                clearTimeout(inactivityTimer);
                clearTimeout(warningTimer);
                clearInterval(countdownTimer);

                if(inactivityModal) inactivityModal.hide();
                countdownSeconds = 60;
                const countdownEl = document.getElementById('logoutCountdown');
                if(countdownEl) countdownEl.innerText = countdownSeconds;

                warningTimer = setTimeout(showWarningModal, warningAfter);

                inactivityTimer = setTimeout(() => {
                    window.location.href = "{{ route('logout') }}";
                }, logoutAfter);
            }

            function showWarningModal(){
                if(inactivityModal) inactivityModal.show();
                countdownTimer = setInterval(() => {
                    countdownSeconds--;
                    const countdownEl = document.getElementById('logoutCountdown');
                    if(countdownEl) countdownEl.innerText = countdownSeconds;

                    if(countdownSeconds <= 0){
                        clearInterval(countdownTimer);
                        window.location.href = "{{ route('logout') }}";
                    }
                }, 1000);
            }

            const stayBtn = document.getElementById('stayLoggedInBtn');
            if(stayBtn) stayBtn.addEventListener('click', resetTimers);

            ['click','mousemove','keypress','scroll'].forEach(event => {
                document.addEventListener(event, resetTimers);
            });

            resetTimers();

        });
        document.addEventListener('DOMContentLoaded', function() {
            let currentDocumentId = null; // tracks active document in modal
            let autosaveTimer;
            let isTyping = false;
            // ================= Initialize Summernote & Select2 =================
            $('#docDescription').summernote({
                placeholder: 'Write details...',
                tabsize: 2,
                height: 300,
                minHeight: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['fontsize', 'color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'table']],
                    ['view', ['codeview']]
                ]
            });
            $('#shareUsers').select2({
                placeholder: "Share With Employees...",
                allowClear: true,
                width: '100%'
            });
            // ================= Privacy Toggle =================
            function handlePrivacySwitch(){
                let value = $('input[name="privacyOptions"]:checked').val();
                $('#privacyStatus').html(`✓ ${value.charAt(0).toUpperCase() + value.slice(1)}`);
                if(value === 'shared'){
                    $('#shareUsersWrapper').removeClass('d-none').addClass('d-block');
                } else {
                    $('#shareUsersWrapper').removeClass('d-block').addClass('d-none');
                    $('#shareUsers').val(null).trigger('change');
                }
            }
            $('input[name="privacyOptions"]').on('change', handlePrivacySwitch);
            function showSavingStatus(){
                $('#autosaveStatus').html('<i class="bi bi-arrow-repeat text-warning"></i> Saving...');
            }
            function triggerAutosave(){
                clearTimeout(autosaveTimer);
                autosaveTimer = setTimeout(autosaveDocument, 1500);
            }
            function autosaveDocument(){
                if(!isTyping) return;
    
                let title = $('#docTitle').val().trim();
                let body = $('#docDescription').summernote('code').trim().replace(/<[^>]*>?/gm, '');
                if(!title && !body) {
                    return;
                }
                let payload = {
                    document_id: currentDocumentId,
                    title: $('#docTitle').val(),
                    body: $('#docDescription').summernote('code'),
                    type: $('#docType').val(),
                    shared_with: $('#shareUsers').val(),
                    is_private: $('input[name="privacyOptions"]:checked').val() === 'private' ? 1 : 0,
                    _token: '{{ csrf_token() }}'
                };
                $.post("{{ route('documents.autosave') }}", payload, function(response){
                    if(response.status === 'saved'){
                        $('#autosaveStatus').html(`<i class="bi bi-check-circle-fill text-success"></i> Saved at ${new Date(response.updated_at).toLocaleTimeString()}`);
                        currentDocumentId = response.document_id;
                        isTyping = false;
                    }
                });
            }
            // Track changes
            $('#docTitle, #docType, #shareUsers').on('input change', function(){
                isTyping = true;
                showSavingStatus();
                triggerAutosave();
            });
            $('#docDescription').on('summernote.change', function(){
                isTyping = true;
                showSavingStatus();
                triggerAutosave();
            });
            // ================= Modal Open / Close =================
            $('#createDocumentModal').on('shown.bs.modal', function () {
                // Reset modal fields for a new document
                currentDocumentId = null;
                isTyping = false;
                $('#docTitle').val('');
                $('#docType').val('general');
                $('#docDescription').summernote('reset'); // clears Summernote
                $('input[name="privacyOptions"][value="private"]').prop('checked', true);
                handlePrivacySwitch();
                $('#autosaveStatus').html('<i class="bi bi-arrow-repeat"></i> Auto-save enabled...');
            });
            // ================= Save Button =================
            $('#saveDocument').on('click', function(){
                showSavingStatus();
                let payload = {
                    document_id: currentDocumentId,
                    title: $('#docTitle').val(),
                    body: $('#docDescription').summernote('code'),
                    type: $('#docType').val(),
                    shared_with: $('#shareUsers').val(),
                    is_private: $('input[name="privacyOptions"]:checked').val() === 'private' ? 1 : 0,
                    _token: '{{ csrf_token() }}'
                };
                $.post("{{ route('documents.autosave') }}", payload, function(response){
                    if(response.status === 'saved'){
                        $('#autosaveStatus').html(`<i class="bi bi-check-circle-fill text-success"></i> Saved at ${new Date(response.updated_at).toLocaleTimeString()}`);
                        currentDocumentId = null; // Reset for next document
                        $('#createDocumentModal').modal('hide'); // Close modal
                    }
                });
            });
        });
    </script>








</body>
</html>
