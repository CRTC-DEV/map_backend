<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Add Device Touch Signage</h1>
            <button wire:click='opensavelist' class="btn btn-primary btn-icon-split btn-submit">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">Add Device Touch Signage</span>
            </button>
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
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>Signage Fields</legend>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="cadId">Cad ID</label>
                                <input wire:model="Signage.cadId" class="form-control" id="cadId"
                                    placeholder="Enter Cad ID" @disabled($isSignageDisabled)>
                                @error('Signage.cadId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="titleId">Title ID</label>
                                <select name="Signage.TitleId" wire:model="Signage.titleId"
                                    class="form-control mb-0 flex-grow-1" id="TitleId"
                                    aria-label="Title select example" style="min-width: 200px;"
                                    @disabled($isSignageDisabled)>
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($map_title as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->OriginalText }}</option>
                                    @endforeach
                                </select>
                                @error('Signage.titleId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="longitudes">Longitudes</label>
                                <input wire:model="Signage.longitudes" class="form-control" id="longitudes"
                                    placeholder="Enter Longitudes" @disabled($isSignageDisabled)>
                                @error('Signage.longitudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="latitudes">Latitudes</label>
                                <input wire:model="Signage.latitudes" class="form-control" id="latitudes"
                                    placeholder="Enter Latitudes" @disabled($isSignageDisabled)>
                                @error('Signage.latitudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="IconUrl">IconUrl</label>
                                <input wire:model="Signage.IconUrl" class="form-control" id="IconUrl"
                                    placeholder="Enter IconUrl" @disabled($isSignageDisabled)>
                                @error('Signage.IconUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="IconUrl">MapUrl</label>
                                <input wire:model="Signage.MapUrl" class="form-control" id="MapUrl"
                                    placeholder="Enter MapUrl" @disabled($isSignageDisabled)>
                                @error('Signage.MapUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="col-md-4 mb-3">
                                <label for="IconUrl">Background Url</label>
                                <input wire:model="Signage.BackgroundUrl" class="form-control" id="BackgroundUrl"
                                    placeholder="Enter BackgroundUrl" @disabled($isSignageDisabled)>
                                @error('Signage.BackgroundUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status">Status</label>
                                <select wire:model="Signage.Status" class="form-control" id="status"
                                    @disabled($isSignageDisabled)>
                                    <option value="">Select Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('Signage.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="IconUrl">Description</label>
                                <textarea wire:model="Signage.Description" class="form-control" id="Description"
                                    placeholder="Enter Description" @disabled($isSignageDisabled)></textarea>
                                @error('Signage.Description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="selectedSignages">Available Signages</label>
                                <input type="checkbox" wire:model="isSignageDisabled" id="device">
                                <select name="selectedSignages" wire:model="selectedSignages"
                                    class="form-control mb-0 flex-grow-1" id="TitleId"
                                    aria-label="Title select example" style="min-width: 200px;"
                                    @disabled(!$isSignageDisabled)>
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($available_signages as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->title->textcontent->OriginalText }}</option>
                                    @endforeach
                                </select>
                                @error('selectedSignages')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <!-- DeviceTouchScreen Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>DeviceTouchScreen Fields</legend>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="deviceCode">Device Code</label>
                                <input wire:model="DeviceTouchScreen.deviceCode" class="form-control" id="deviceCode"
                                    placeholder="Enter Device Code" @disabled($isDeviceTouchScreenDisabled)>
                                @error('DeviceTouchScreen.deviceCode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="deviceSerial">Device Serial</label>
                                <input wire:model="DeviceTouchScreen.deviceSerial" class="form-control"
                                    id="deviceSerial" placeholder="Enter Device Serial" @disabled($isDeviceTouchScreenDisabled)>
                                @error('DeviceTouchScreen.deviceSerial')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="titleId">Location ID</label>
                                <select name="DeviceTouchScreen.locationId" wire:model="DeviceTouchScreen.locationId"
                                    class="form-control mb-0 flex-grow-1" id="TitleId"
                                    aria-label="Title select example" style="min-width: 200px;"
                                    @disabled($isDeviceTouchScreenDisabled)>
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($location as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->Name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('DeviceTouchScreen.locationId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="longitudes">Longitudes</label>
                                <input wire:model="DeviceTouchScreen.longitudes" class="form-control" id="longitudes"
                                    placeholder="Enter Longitudes" @disabled($isDeviceTouchScreenDisabled)>
                                @error('DeviceTouchScreen.longitudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="latitudes">Latitudes</label>
                                <input wire:model="DeviceTouchScreen.latitudes" class="form-control" id="latitudes"
                                    placeholder="Enter Latitudes" @disabled($isDeviceTouchScreenDisabled)>
                                @error('DeviceTouchScreen.latitudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="deviceStatus">Device Status</label>
                                <select wire:model="DeviceTouchScreen.deviceStatus" class="form-control"
                                    id="deviceStatus" @disabled($isDeviceTouchScreenDisabled)>
                                    <option value="">Select Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('DeviceTouchScreen.deviceStatus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="selectedDevices">Available Device Touch Screen</label>
                                <input type="checkbox" wire:model="isDeviceTouchScreenDisabled" value=""
                                    id="device">
                                <select name="selectedDevices" wire:model="selectedDevices"
                                    class="form-control mb-0 flex-grow-1" id="available_deviceTouchScreens"
                                    aria-label="Title select example" style="min-width: 200px;"
                                    @disabled(!$isDeviceTouchScreenDisabled)>
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($available_deviceTouchScreens as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->DeviceCode }}</option>
                                    @endforeach
                                </select>
                                @error('selectedDevices')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <!-- SignageDeviceTouch Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>SignageDeviceTouch Fields</legend>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="linkStatus">SignageDeviceTouch Status</label>
                                <select wire:model="SignageDeviceTouch.Status" class="form-control" id="linkStatus">
                                    <option value="">Select Link Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('SignageDeviceTouch.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="orderIndex">Order Index</label>
                                <input wire:model="SignageDeviceTouch.orderIndex" type="number" class="form-control"
                                    id="orderIndex" placeholder="Enter Order Index">
                                @error('SignageDeviceTouch.orderIndex')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('signage-devicetouch') }}" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                    <button type="submit" class="btn btn-primary btn-icon-split btn-submit">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Save Item</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    @include('livewire.popup.list_signage_devicetouch_modal')
</div>
@section('script')
    <script>
        //Transalation
        document.addEventListener('livewire:load', function() {
            Livewire.on('openListDeviceTouchSignage', (originalText) => {
                $('#listDeviceTouchSignageModal').modal('show'); // Assuming Bootstrap modal
            });
        });
    </script>
@endsection
