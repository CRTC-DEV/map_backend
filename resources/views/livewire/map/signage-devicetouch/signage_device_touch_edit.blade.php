<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Edit Device Touch Signage</h1>
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
                    <!-- Signage Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>Signage Fields</legend>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="cadId">Cad ID</label>
                                <input wire:model.defer="Signage.CadId" class="form-control" id="cadId"
                                    placeholder="Enter Cad ID">
                                @error('Signage.CadId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="titleId">Title ID</label>
                                <select wire:model.defer="Signage.TitleId" class="form-control" id="titleId">
                                    <option value="">Please select</option>
                                    @foreach ($map_title as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->OriginalText }}</option>
                                    @endforeach
                                </select>
                                @error('Signage.TitleId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="longitudes">Longitudes</label>
                                <input wire:model.defer="Signage.Longitudes" class="form-control"
                                    id="longitudes" placeholder="Enter Longitudes">
                                @error('Signage.Longitudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="latitudes">Latitudes</label>
                                <input wire:model.defer="Signage.Latitudes" class="form-control"
                                    id="latitudes" placeholder="Enter Latitudes">
                                @error('Signage.Latitudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="IconUrl">IconUrl</label>
                                <input wire:model="Signage.IconUrl" class="form-control" id="IconUrl"
                                    placeholder="Enter IconUrl">
                                @error('Signage.IconUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="IconUrl">MapUrl</label>
                                <input wire:model="Signage.MapUrl" class="form-control" id="MapUrl"
                                    placeholder="Enter MapUrl">
                                @error('Signage.MapUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="IconUrl">Background Url</label>
                                <input wire:model="Signage.BackgroundUrl" class="form-control" id="BackgroundUrl"
                                    placeholder="Enter BackgroundUrl">
                                @error('Signage.BackgroundUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status">Status</label>
                                <select wire:model="Signage.Status" class="form-control" id="status">
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
                                    placeholder="Enter Description"></textarea>
                                @error('Signage.Description')
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
                                <input wire:model.defer="DeviceTouchScreen.DeviceCode" class="form-control"
                                    id="deviceCode" placeholder="Enter Device Code">
                                @error('DeviceTouchScreen.DeviceCode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="deviceSerial">Device Serial</label>
                                <input wire:model.defer="DeviceTouchScreen.DeviceSerial" class="form-control"
                                    id="deviceSerial" placeholder="Enter Device Serial">
                                @error('DeviceTouchScreen.DeviceSerial')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="titleId">Location ID</label>
                                <select name="DeviceTouchScreen.T2LocationId"
                                    wire:model="DeviceTouchScreen.T2LocationId" class="form-control mb-0 flex-grow-1"
                                    id="TitleId" aria-label="Title select example" style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($location as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->Name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('DeviceTouchScreen.T2LocationId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="longitudes">Longitudes</label>
                                <input wire:model.defer="DeviceTouchScreen.Longitudes"
                                    class="form-control" id="longitudes" placeholder="Enter Longitudes">
                                @error('DeviceTouchScreen.Longitudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="latitudes">Latitudes</label>
                                <input wire:model.defer="DeviceTouchScreen.Latitudes"
                                    class="form-control" id="latitudes" placeholder="Enter Latitudes">
                                @error('DeviceTouchScreen.latitudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="deviceStatus">Device Status</label>
                                <select wire:model.defer="DeviceTouchScreen.Status" class="form-control"
                                    id="deviceStatus">
                                    <option value="">Select Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('DeviceTouchScreen.Status')
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
                                <select wire:model.defer="SignageDeviceTouch.Status" class="form-control"
                                    id="linkStatus">
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
                                <input wire:model.defer="SignageDeviceTouch.OrderIndex" type="number"
                                    class="form-control" id="orderIndex" placeholder="Enter Order Index">
                                @error('SignageDeviceTouch.OrderIndex')
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
