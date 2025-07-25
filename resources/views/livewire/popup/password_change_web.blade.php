<div wire:ignore.self class="modal fade" id="password_change" tabindex="-1" aria-labelledby="password_changeLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="password_changeLabel">Change Password</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (Session::has('messages'))
                    <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
                        {{ Session::get('messages') }}
                    </div>
                @endif
                <div class="form-group">
                    <input type="password" wire:model="old_password" class="form-control"
                        placeholder="Enter old password">
                    @error('old_password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-2">
                    <input type="password" wire:model="new_password" class="form-control"
                        placeholder="Enter new password">
                    @error('new_password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-2">
                    <input type="password" wire:model="new_password_confirmation" class="form-control"
                        placeholder="Confirm new password">
                    @error('new_password_confirmation')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
