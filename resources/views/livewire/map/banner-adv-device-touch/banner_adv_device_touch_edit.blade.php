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
                        <label for="banner_adv_device_touch.BannerAdvId">Banner Adv</label>
                        {{-- Use only defer when form edit wire:model.defer --}}
                        <select name="banner_adv_device_touch.BannerAdvId" wire:model="banner_adv_device_touch.BannerAdvId" class="form-control mb-0" id="BannerAdvId"
                            aria-label="Gender select example">                                                     
                            @foreach($banner_adv as $item)
                                <option value="{{$item->Id}}" >{{$item->Id}} - {{$item->title}}</option>
                            @endforeach
                        </select>
                        @error('banner_adv_device_touch.BannerAdvId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="banner_adv_device_touch.DeviceTouchScreenId">Device Touch</label>
                        <select name="banner_adv_device_touch.DeviceTouchScreenId" wire:model="banner_adv_device_touch.DeviceTouchScreenId" class="form-control mb-0" id="DeviceTouchScreenId"
                            aria-label="Gender select example">                          
                            @foreach($device_touch as $item)
                                <option value="{{$item->Id}}" >{{$item->Id}} - {{$item->DeviceCode}}|{{$item->DeviceSerial}}</option>
                            @endforeach
                        </select>
                        @error('banner_adv_device_touch.DeviceTouchScreenId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="banner_adv_device_touch.Status">Status </label>
                        <select name="banner_adv_device_touch.Status" wire:model="banner_adv_device_touch.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('banner_adv_device_touch.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>                
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('banner-adv-device-touch') }}" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                     <div class="ml-auto d-flex">
                        <button type="submit2" class="btn btn-primary btn-icon-split btn-submit mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Save Item</span>
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