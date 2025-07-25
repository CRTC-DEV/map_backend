<div wire:ignore.self class="modal fade" id="password_change" tabindex="-1" aria-labelledby="password_changeLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="savePasswordChanged">
                <div class="modal-header">
                    <h5 class="modal-title" id="password_changeLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="old_password">Current Password</label>
                        <input type="password" wire:model="old_password" 
                            class="form-control @error('old_password') is-invalid @enderror" 
                            id="old_password" placeholder="Enter current password">
                        @error('old_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="new_password">New Password</label>
                        <input type="password" wire:model="new_password" 
                            class="form-control @error('new_password') is-invalid @enderror" 
                            id="new_password" placeholder="Enter new password">
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" wire:model="new_password_confirmation" 
                            class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                            id="new_password_confirmation" placeholder="Confirm new password">
                        @error('new_password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
