<!-- Withdrawal Rejection Modal -->
<div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="mr-auto text-base font-medium">Reject <strong id="reject-withdrawal-user-name"></strong> Withdrawal</h2>
            </div>
            <form id="withdraw-reject-form" action="{{ isset($withdrawal) ? route('admin.reject_withdrawal', $withdrawal->id) : '#' }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="col-span-12 sm:col-span-6 mb-2">
                        <label for="reject-withdrawal-amount" class="form-label">Amount</label>
                        <input id="reject-withdrawal-amount" type="number" class="form-control" disabled>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="reject-reason" class="form-label">Rejection Reason</label>
                        <input id="rejection_reason" name="rejection_reason" type="text" class="form-control" placeholder="Enter Reason" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="w-20 mr-1 btn btn-outline-secondary">Cancel</button>
                    <button type="submit" class="w-20 btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
