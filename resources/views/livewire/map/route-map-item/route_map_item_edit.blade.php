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
                        <label for="Name">Name</label>
                        <input wire:model="route_map_item.Name" class="form-control" id="Name">
                        @error('route_map_item.Name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <!-- <div class="col-md-3 mb-3">
                        <label for="StartMapItemId">Start Map Item </label>
                        <input wire:model="route_map_item.StartMapItemId" class="form-control" id="TitleId">
                        @error('route_map_item.StartMapItemId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="CadId">End Map Item</label>
                        <input wire:model="route_map_item.EndMapItemId" class="form-control" id="CadId">
                        @error('route_map_item.route_map_item.EndMapItemId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> -->
                    <div class="col-md-3 mb-3">
                        <label for="map_item.StartMapItemId">Start Map Item</label>
                        <select name="route_map_item.StartMapItemId" wire:model="route_map_item.StartMapItemId" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <!-- <option value="{{ null }}">please select</option> -->
                            @foreach($map_item as $item)
                                <option value="{{$item->Id}}" >{{$item->CadId}} - {{$item->TitleText}}</option>
                            @endforeach
                        </select>
                        @error('map_item.StartMapItemId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="map_item.Status">End Map Item</label>
                        <select name="route_map_item.EndMapItemId" wire:model="route_map_item.EndMapItemId" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <!-- <option value="{{ null }}">please select</option> -->
                            @foreach($map_item as $item)
                                <option value="{{$item->Id}}" >{{$item->CadId}} - {{$item->TitleText}}</option>
                            @endforeach
                        </select>
                        @error('map_item.EndMapItemId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="map_item.Status">Status </label>
                        <select name="route_map_item.Status" wire:model="route_map_item.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('map_item.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                   
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('route-map-item') }}" class="btn btn-secondary btn-icon-split">
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