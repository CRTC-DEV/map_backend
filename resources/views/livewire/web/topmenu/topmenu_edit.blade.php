<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Edit TopMenu</h1>
        </div>
    </div>
    @if (Session::has('message'))
        <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div wire:key="form-add" class="mb-5">
        <form wire:submit.prevent="save">
            {{-- Data info --}}
            <div class="card card-body border-0 shadow mb-4">
                <div class="row">
                    <!-- TopMenu Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>TopMenu Fields</legend>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="titleId">Title ID</label>
                                <select wire:model.defer="TopMenu.TitleId" class="form-control" id="titleId">
                                    <option value="">Please select</option>
                                    @foreach ($item_title as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->OriginalText }}</option>
                                    @endforeach
                                </select>
                                @error('TopMenu.TitleId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status">Status</label>
                                <select wire:model="TopMenu.Status" class="form-control" id="status">
                                    <option value="">Select Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('TopMenu.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div wire:ignore class="col-md-12 mb-3">
                                <label for="IconUrl">OrderIndex</label>
                                <textarea wire:model="TopMenu.OrderIndex" class="form-control" id="OrderIndex"
                                    placeholder="Enter OrderIndex"></textarea>
                                @error('TopMenu.OrderIndex')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('admin.topmneu') }}" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                    <div class="ml-auto d-flex">
                        <button type="submit" class="btn btn-primary btn-icon-split btn-submit mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Update Item</span>
                        </button>
                        <a wire:click="delete" class="btn btn-danger btn-icon-split mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Deleted</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@section('script')

@endsection
