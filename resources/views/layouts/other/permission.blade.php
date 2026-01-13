<div class="modal fade" id="permissionModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header py-2">
                <h6 class="modal-title">Assign Permissions</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pb-1">
                <div id="selectedUserName" class="fw-bold small mb-2"></div>

                <div class="form-check">
                    <input class="form-check-input perm-check" type="checkbox" value="view">
                    <label class="form-check-label small">View</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input perm-check" type="checkbox" value="edit">
                    <label class="form-check-label small">Edit</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input perm-check" type="checkbox" value="comment">
                    <label class="form-check-label small">Comment</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input perm-check" type="checkbox" value="download">
                    <label class="form-check-label small">Download</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input perm-check" type="checkbox" value="print">
                    <label class="form-check-label small">Print</label>
                </div>
            </div>

            <div class="modal-footer py-1">
                <button type="button" id="savePermissions" class="btn btn-sm btn-primary">Save</button>
            </div>

        </div>
    </div>
</div>
