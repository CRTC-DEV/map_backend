<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Your Information</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <form wire:submit.prevent='savePasswordChanged'>
                <fieldset class="col-md-12 mb-4 border p-3">
                    <legend>Welcome {{ $admin->name }}</legend>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input wire:model="admin.email" type="email" class="form-control" id="email"
                                placeholder="Enter Email Address..." disabled>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">FullName</label>
                            <input wire:model.defer="admin.name" type="text" class="form-control" id="name"
                                placeholder="Enter Your Name...">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>
                <div class="mt-3 d-flex justify-content-between">
                    <a wire:click="addChangePasswordModal"
                        class="btn btn-primary btn-icon-split btn-submit justify-content-center">
                        <span class="icon text-white-50">
                            {{-- <i class="fas fa-arrow-right"></i> --}}
                        </span>
                        <span class="text"> Change password</span>
                    </a>
                </div>
                @include('livewire.popup.password_change_web')
            </div>
        </form>
    </div>
</div>

@section('script')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('openChangePasswordModal',() => {
                $('#password_change').modal('show'); // Assuming Bootstrap modal
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('closeChangePasswordModal', () => {
                $('#password_change').modal('hide');
            });
        });
    </script>
@endsection