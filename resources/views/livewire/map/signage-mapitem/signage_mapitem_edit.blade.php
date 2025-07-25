<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Edit Signage MapItem</h1>
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
                        <legend>Signage MapItem Fields</legend>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="SignageMapItem.SignageId">Available Signage</label>
                                {{-- <input type="checkbox" wire:model="isDeviceTouchScreenDisabled" value=""
                                    id="device"> --}}
                                <select name="SignageMapItem.SignageId" wire:model="SignageMapItem.SignageId"
                                    class="form-control mb-0 flex-grow-1" id="available_deviceTouchScreens"
                                    aria-label="Title select example" style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($Signage as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->title->textcontent->OriginalText }}</option>
                                    @endforeach
                                </select>
                                @error('SignageMapItem.SignageId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="col-md-12 mb-3">
                                <label for="selectedDevices">Available Map Item Screen</label>
                                {{-- <input type="checkbox" wire:model="isDeviceTouchScreenDisabled" value=""
                                    id="device"> --}}
                                <select name="SignageMapItem.MapItemId" wire:model="SignageMapItem.MapItemId"
                                    class="form-control mb-0 flex-grow-1" id="available_deviceTouchScreens"
                                    aria-label="Title select example" style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($MapItem as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->CadId }} - {{$item->TitleText}}</option>
                                    @endforeach
                                </select>
                                @error('SignageMapItem.MapItemId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="linkStatus">SignageMapItem Status</label>
                                <select wire:model="SignageMapItem.Status" class="form-control" id="linkStatus">
                                    <option value="">Select Link Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('SignageMapItem.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('signage-mapitem') }}" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                    <div class="ml-auto d-flex">
                        <a wire:click="delete" class="btn btn-danger btn-icon-split mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Deleted</span>
                        </a> 
                        <button type="submit" class="btn btn-primary btn-icon-split btn-submit">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Update Item</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>