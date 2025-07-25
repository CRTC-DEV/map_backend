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
                    <!-- <div class="col-md-3 mb-3">
                        <label for="StartMapItemId">Route Map Item Id</label>
                        <input wire:model="route_map_item_detail.RouteMapItemId" class="form-control" id="TitleId">
                        @error('route_map_item.StartMapItemId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> -->
                    <div class="col-md-3 mb-3">
                        <label for="map_item.Status">Route Map Item</label>
                        <select name="route_map_item_detail.RouteMapItemId" wire:model="route_map_item_detail.RouteMapItemId" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            @foreach($route_map_item as $item)
                                <option value="{{$item->Id}}" >{{$item->Id}} - {{$item->Name}}</option>
                            @endforeach
                        </select>
                        @error('route_map_item_detail.RouteMapItemId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="CadId">Name Index</label>
                        <input wire:model="route_map_item_detail.NameIndex" class="form-control" id="CadId">
                        @error('route_map_item_detail.NameIndex') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="CadId">Longitudes</label>
                        <input wire:model="route_map_item_detail.Longitudes" class="form-control" id="CadId">
                        @error('route_map_item_detail.Longitudes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="CadId">Latitudes</label>
                        <input wire:model="route_map_item_detail.Latitudes" class="form-control" id="CadId">
                        @error('route_map_item_detail.Latitudes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="CadId">OrderIndex</label>
                        <input wire:model="route_map_item_detail.OrderIndex" class="form-control" id="CadId">
                        @error('route_map_item_detail.OrderIndex') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="map_item.Status">Status </label>
                        <select name="route_map_item_detail.Status" wire:model="route_map_item_detail.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('route_map_item_detail.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                   
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('route-map-item-detail') }}" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                    <button type="submit" class="btn btn-primary btn-icon-split btn-submit">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Add Item</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>