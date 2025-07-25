<!-- List DeviceTouchGroupFunction Modal -->
<div wire:ignore.self class="modal fade" id="listDeviceTouchGroupFunctionModal" tabindex="-1"
    aria-labelledby="listDeviceTouchGroupFunctionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listDeviceTouchGroupFunctionModalLabel">Add Group Function Device Touch</h5>
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
                <div class=" d-flex">
                    <!-- GroupFunctions List -->
                    <div class="w-50 pr-2 border-right">
                        <h6>GroupFunctions</h6>
                        @foreach ($available_groupfunctions as $sign)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="selectedGroupFunctions"
                                    value="{{ $sign->Id }}" id="groupfunction_{{ $sign->Id }}">
                                <label class="form-check-label" for="groupfunction_{{ $sign->Id }}">
                                    {{ $sign->Id }} - {{ $sign->title->textcontent->OriginalText }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <!-- DeviceTouchScreen List -->
                    <div class="w-50 pl-2">
                        <h6>Device Touch Screens</h6>
                        @foreach ($available_deviceTouchScreens as $device)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="selectedDevices"
                                    value="{{ $device->Id }}" id="device_{{ $device->Id }}">
                                <label class="form-check-label" for="device_{{ $device->Id }}">
                                    {{ $device->Id }} - {{ $device->DeviceCode }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- GroupFunctionDeviceTouch Fields -->
                <fieldset class="col-md-12 mb-4 border p-3">
                    <legend>GroupFunctionDeviceTouch Fields</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
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
                        <div class="col-md-6 mb-3">
                            <label for="orderIndex">Order Index</label>
                            <input wire:model="GroupFunctionDeviceTouch.orderIndex" type="number" class="form-control"
                                id="orderIndex" placeholder="Enter Order Index">
                            @error('GroupFunctionDeviceTouch.orderIndex')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click='insertlist' class="btn btn-primary" wire:click="saveSelections">Save
                    Selections</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal ListDeviceTouchGroupFunction -->
