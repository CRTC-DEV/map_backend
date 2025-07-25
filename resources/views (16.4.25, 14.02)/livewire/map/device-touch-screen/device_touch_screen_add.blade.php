<div>
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

                    <div class="col-md-3 mb-3">
                        <label for="Name">DeviceCode</label>
                        <input wire:model.defer="device_touch_screen.DeviceCode" class="form-control" id="DeviceCode">
                        @error('device_touch_screen.DeviceCode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="Description">DeviceSerial</label>
                        <input wire:model="device_touch_screen.DeviceSerial" class="form-control" id="DeviceSerial">
                        @error('device_touch_screen.DeviceSerial') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="device_touch_screen.Status">T2Location</label>

                        <select name="device_touch_screen.T2LocationId" wire:model="device_touch_screen.T2LocationId" class="form-control mb-0" id="Status" aria-label="Gender select example">
                            <option value="{{ null }}">Please select</option>
                            @foreach ($t2location as $t2)
                            <option value="{{ $t2->Id }}">{{ $t2->Id }} - {{ $t2->Name }}
                            </option>
                            @endforeach
                        </select>
                        @error('device_touch_screen.T2LocationId')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="Longitudes">Longitudes</label>
                        <input wire:model="device_touch_screen.Longitudes" class="form-control" id="Longitudes">
                        @error('device_touch_screen.Longitudes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="Latitudes">Latitudes</label>
                        <input wire:model="device_touch_screen.Latitudes" class="form-control" id="latitudes">
                        @error('device_touch_screen.Latitudes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-3 mb-3">
                        <label for="device_touch_screen.Status">Status </label>
                        <select name="device_touch_screen.Status" wire:model="device_touch_screen.Status" class="form-control mb-0" id="Status" aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            <option value="1">Disable</option>
                            <option value="2">Enable</option>
                        </select>
                        @error('device_touch_screen.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('device-touch-screen') }}" class="btn btn-secondary btn-icon-split">
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
</div>