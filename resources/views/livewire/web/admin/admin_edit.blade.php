<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            {{-- <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item"><a href="{{route('admin-management')}}">admin Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add admin</li>
                </ol>
            </nav> --}}
            <h1 class="h1">Edit Admin</h1>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-12">
            <form wire:submit.prevent="save">
                <div class="card card-body border-0 shadow mb-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div>
                                <label for="name">Name</label>
                                <input wire:model="admin.name" class="form-control" id="name" type="text">
                            </div>
                            @error('admin.name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input wire:model="admin.email" class="form-control" id="email" type="text">
                            </div>
                            @error('admin.email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <div>
                                <label for="password">Password Text</label>
                                <input wire:model="admin.password_text" class="form-control" id="password"
                                    type="text">
                            </div>
                            @error('admin.password_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card card-body border-0 shadow mb-4">
                    <div class="row mb-3">
                        <h5 class="ml-3">Select Role</h5>
                    </div>
                    @if (auth()->guard('admin')->user()->role_id == ROLE_ADMIN)
                        <div class="row">
                            <div class="col-md 12">
                                <div class="portlet box">
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="radio radio-primary cursor-pointer">
                                                        <input wire:model="admin.role_id" type="radio" name="role" value="{{ROLE_ADMIN}}">
                                                        Admin
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="radio radio-primary cursor-pointer">
                                                        <input wire:model="admin.role_id" type="radio" name="role" value="{{ROLE_STAFF}}">
                                                        Staff
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="radio radio-primary cursor-pointer">
                                                        <input wire:model="admin.role_id" type="radio" name="role" value="{{ROLE_AUTHOR}}">
                                                        Author
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('admin.web') }}" class="btn btn-secondary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span>
                        </a>
                        <button type="submit" class="btn btn-primary btn-icon-split btn-submit">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Save</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
