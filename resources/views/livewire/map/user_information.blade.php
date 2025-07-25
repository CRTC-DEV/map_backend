<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Your Information</h1>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row mb-5">
        <div class="col-12">
            <!-- Profile Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
                    @if(!$updateMode)
                        <button wire:click="enableEdit" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit fa-sm"></i> Edit Profile
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent='saveProfileInformation'>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email"
                                    value="{{ $user->email }}" disabled>
                                <small class="text-muted">Email cannot be changed</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input wire:model.defer="user.name" type="text" 
                                    class="form-control @error('user.name') is-invalid @enderror" 
                                    id="name" placeholder="Enter Your Name..."
                                    @if(!$updateMode) disabled @endif>
                                @error('user.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        @if($updateMode)
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="button" wire:click="cancelEdit" class="btn btn-secondary mr-2">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Security Card -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Security</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Password</h5>
                            <p class="text-muted mb-0">Update your password to keep your account secure</p>
                        </div>
                        <button wire:click="addChangePasswordModal" class="btn btn-primary">
                            <i class="fas fa-lock fa-sm"></i> Change Password
                        </button>
                    </div>
                </div>
            </div>

            <!-- Password Change Modal -->
            @include('livewire.popup.password_change_user')
        </div>
    </div>
</div>

@section('script')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('openChangePasswordModal',() => {
                $('#password_change').modal('show');
            });
            
            Livewire.on('closeChangePasswordModal', () => {
                $('#password_change').modal('hide');
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
@endsection
