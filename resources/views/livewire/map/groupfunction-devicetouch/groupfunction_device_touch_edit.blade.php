<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Edit Device Touch GroupFunction</h1>
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
                                <label for="GroupFunctionDeviceTouch.GroupFunctionId">Available GroupFunctions</label>
                                <select name="GroupFunctionDeviceTouch.GroupFunctionId" wire:model="GroupFunctionDeviceTouch.GroupFunctionId"
                                    class="form-control mb-0 flex-grow-1" id="TitleId"
                                    aria-label="Title select example" style="min-width: 200px;"
                                    >
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($available_groupfunctions as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->title->textcontent->OriginalText }}</option>
                                    @endforeach
                                </select>
                                @error('GroupFunctionDeviceTouch.GroupFunctionId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <!-- DeviceTouchScreen Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="selectedDevices">Available Device Touch Screen</label>
                                <select name="selectedDevices" wire:model="GroupFunctionDeviceTouch.DeviceTouchScreenId"
                                    class="form-control mb-0 flex-grow-1" id="available_deviceTouchScreens"
                                    aria-label="Title select example" style="min-width: 200px;"
                                    >
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($available_deviceTouchScreens as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->DeviceCode }}</option>
                                    @endforeach
                                </select>
                                @error('GroupFunctionDeviceTouch.DeviceTouchScreenId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <!-- GroupFunctionDeviceTouch Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>GroupFunctionDeviceTouch Fields</legend>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="linkStatus">GroupFunctionDeviceTouch Status</label>
                                <select wire:model="GroupFunctionDeviceTouch.Status" class="form-control" id="linkStatus">
                                    <option value="">Select Link Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('GroupFunctionDeviceTouch.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="col-md-3 mb-3">
                                <label for="orderIndex">Order Index</label>
                                <input wire:model.defer="GroupFunctionDeviceTouch.OrderIndex" type="number"
                                    class="form-control" id="orderIndex" placeholder="Enter Order Index">
                                @error('GroupFunctionDeviceTouch.OrderIndex')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('groupfunction-devicetouch') }}" class="btn btn-secondary btn-icon-split">
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
