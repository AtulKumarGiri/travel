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
            // ================= Initialize Summernote & Select2 =================
            $('#docDescription').summernote({
                placeholder: 'Write details...',
                tabsize: 2,
                height: 350,
                minHeight: 250,
                toolbar: [
                    ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['font', ['fontsize', 'color', 'highlight']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['picture', 'link', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                    ['misc', ['undo', 'redo']],
                    ['excel', ['excelImport']], // custom
                ],
            });

            $('#shareUsers').select2({
                placeholder: "Share With Employees...",
                allowClear: true,
                width: '100%',
                padding: '10px',
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
            let autosaveTimer = null;
            let isTyping = false;
            let currentDocumentId = null;   // important

            function showSavingStatus(){
                $('#autosaveStatus').html(`<i class="bi bi-arrow-repeat text-warning"></i> Saving...`);
            }

            function triggerAutosave(){
                clearTimeout(autosaveTimer);
                autosaveTimer = setTimeout(autosaveDocument, 1500);
            }

            function autosaveDocument() {
                if (!isTyping) return;

                let title = $('#docTitle').val().trim();
                let bodyText = $('#docDescription').summernote('code').trim().replace(/<[^>]*>?/gm, '');

                // Nothing to save?
                if (!title && !bodyText) return;

                let payload = {
                    document_id: currentDocumentId ?? null,
                    title: $('#docTitle').val(),
                    body: $('#docDescription').summernote('code'),
                    type: $('#docType').val(),
                    shared_with: $('#shareUsers').val(),
                    is_private: $('input[name="privacyOptions"]:checked').val() === 'private' ? 1 : 0,
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                let url = currentDocumentId
                    ? "/documents/update"  // update existing
                    : "/documents/store";  // create new

                $.post(url, payload)
                    .done(function (response) {

                        // Backend must return status = "saved"
                        if (response.status === 'saved' || response.status === 'success') {

                            // assign id if newly created
                            currentDocumentId = response.document_id;

                            let time = response.updated_at
                                ? new Date(response.updated_at).toLocaleTimeString()
                                : new Date().toLocaleTimeString();

                            $('#autosaveStatus').html(
                                `<i class="bi bi-check-circle-fill text-success"></i> Saved at ${time}`
                            );

                            isTyping = false;
                        }
                    })
                    .fail(function (xhr) {
                        console.error("Autosave error:", xhr.responseText);
                        $('#autosaveStatus').html(`<span class="text-danger">Autosave failed</span>`);
                    });
            }


            // EVENT TRACKERS (Triggers autosave)
            $('#docTitle, #docType, #shareUsers, input[name="privacyOptions"]').on('input change', function(){
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
                $.post("{{ route('documents.store') }}", payload, function(response){
                    if(response.status === 'saved'){
                        $('#autosaveStatus').html(`<i class="bi bi-check-circle-fill text-success"></i> Saved at ${new Date(response.updated_at).toLocaleTimeString()}`);
                        currentDocumentId = null; // Reset for next document
                        $('#createDocumentModal').modal('hide'); // Close modal
                    }
                });
            });
        });

        const permissionOptions = `
            <option value="View">View</option>
            <option value="Edit">Edit</option>
            <option value="Comment">Comment</option>
            <option value="Download">Download</option>
        `;

        $('#shareUsers').on('change', function(){
            const selectedUsers = $(this).val() || [];
            const container = $('#userPermissions');
            container.empty();

            selectedUsers.forEach(userId => {
                const userName = $('#shareUsers option[value="'+userId+'"]').text();
                container.append(`
                    <div class="d-flex align-items-center mb-1">
                        <span class="small me-2 fw-bold">${userName}</span>
                        <select name="permissions[${userId}]" class="form-select form-select-sm" style="width:140px;">
                            ${permissionOptions}
                        </select>
                    </div>
                `);
            });
        });

        let selectedPermissions = {}; // { userId: ['view','edit'] }
        let currentUserId = null;

        const permissionModal = new bootstrap.Modal(document.getElementById('permissionModal'));

        $('#shareUsers').on('change', function() {
            const selected = $(this).val() || [];

            selected.forEach(id => {
                if(!selectedPermissions[id]) {
                    currentUserId = id;
                    $('#selectedUserName').text($('#shareUsers option[value="'+id+'"]').text());
                    $('.perm-check').prop('checked', false);
                    permissionModal.show();
                }
            });

            renderPermissions();
        });

        $('#savePermissions').on('click', function() {
            const perms = [];
            $('.perm-check:checked').each(function() {
                perms.push($(this).val());
            });

            if(perms.length === 0){
                alert("Select at least one permission");
                return;
            }

            selectedPermissions[currentUserId] = perms;
            permissionModal.hide();
            renderPermissions();
        });

        function renderPermissions(){
            const container = $('#userPermissions');
            container.empty();

            Object.keys(selectedPermissions).forEach(id => {
                const name = $('#shareUsers option[value="'+id+'"]').text();
                const perms = selectedPermissions[id]
                    .map(p => `<span class="badge bg-info text-dark me-1">${p}</span>`)
                    .join('');

                container.append(`
                    <div class="mb-1 small d-flex justify-content-between align-items-center">
                        <span>${name}: ${perms}</span>
                        <button class="btn btn-sm btn-danger remove-user" data-id="${id}"><i class="bi bi-x"></i></button>
                    </div>
                `);
            });
        }

        $(document).on('click','.remove-user',function(){
            const id = $(this).data('id');
            delete selectedPermissions[id];

            let values = $('#shareUsers').val();
            values = values.filter(v => v != id);
            $('#shareUsers').val(values).trigger('change');
        });


    </script>








</body>
</html>
