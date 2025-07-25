<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Edit  GroupFunction</h1>
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
                    <!-- GroupFunction Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>GroupFunction Fields</legend>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="GroupMainFunction.GroupFunctionId">Available GroupFunctions</label>
                                <select name="GroupMainFunction.GroupFunctionId" wire:model="GroupMainFunction.GroupFunctionId"
                                    class="form-control mb-0 flex-grow-1" id="TitleId"
                                    aria-label="Title select example" style="min-width: 200px;"
                                    >
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($available_groupfunctions as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->title->textcontent->OriginalText }}</option>
                                    @endforeach
                                </select>
                                @error('GroupMainFunction.GroupFunctionId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <!-- DeviceTouchScreen Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="selectedDevices">Available  MainFunction</label>
                                <select name="selectedDevices" wire:model="GroupMainFunction.MainFunctionId"
                                    class="form-control mb-0 flex-grow-1" id="available_mainfunctions"
                                    aria-label="Title select example" style="min-width: 200px;"
                                    >
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($available_mainfunctions as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->title->textcontent->OriginalText  }}</option>
                                    @endforeach
                                </select>
                                @error('GroupMainFunction.MainFunctionId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <!-- GroupMainFunction Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>GroupMainFunction Fields</legend>
                        <div class="row">                            <div class="col-md-3 mb-3">
                                <label for="linkStatus">GroupMainFunction Status</label>
                                <select wire:model="GroupMainFunction.Status" class="form-control" id="linkStatus">
                                    <option value="">Select Link Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('GroupMainFunction.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>                            
                            <div class="col-md-3 mb-3">
                                <label for="IsShowBothLocation">Show Both Location</label>
                                <select wire:model="GroupMainFunction.IsShowBothLocation" class="form-control" id="IsShowBothLocation">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                                @error('GroupMainFunction.IsShowBothLocation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="col-md-3 mb-3">
                                <label for="orderIndex">Order Index</label>
                                <input wire:model.defer="GroupMainFunction.OrderIndex" type="number"
                                    class="form-control" id="orderIndex" placeholder="Enter Order Index">
                                @error('GroupMainFunction.OrderIndex')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('group-mainfunction') }}" class="btn btn-secondary btn-icon-split">
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
    <script>
        document.addEventListener('livewire:load', function() {
            flatpickr('#startDateInput', {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });

            flatpickr('#expiryDateInput', {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });
        });
    </script>
@endsection
