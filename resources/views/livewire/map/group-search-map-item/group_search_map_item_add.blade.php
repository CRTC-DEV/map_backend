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
                        <label for="group_search_map_item.GroupSearchId">GroupSearch </label>
                        <select TextContentId="group_search_map_item.GroupSearchId" wire:model="group_search_map_item.GroupSearchId" class="form-control mb-0" id="GroupSearchId"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            @foreach($group_search as $item)
                                <option value="{{ $item->Id }}">{{ $item->Id }}-{{ $item->Name }}|{{ $item->KeySearch }}</option>
                            @endforeach
                        </select>
                        @error('group_search_map_item.GroupSearchId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> 
                    <div class="col-md-3 mb-3">
                        <label for="group_search_map_item.MapItemId">MapItem </label>
                        <select TextContentId="group_search_map_item.MapItemId" wire:model="group_search_map_item.MapItemId" class="form-control mb-0" id="MapItemId"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            @foreach(\App\Models\Map\MapItem::all() as $item)
                                <option value="{{ $item->Id }}">{{ $item->Id }}-{{ $item->KeySearch }}</option>
                            @endforeach
                        </select>
                        @error('group_search_map_item.MapItemId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="group_search_map_item.Status">Status </label>
                        <select TextContentId="group_search_map_item.Status" wire:model="group_search_map_item.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('group_search_map_item.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="Priority">Priority</label>
                        <input wire:model="group_search_map_item.Priority" class="form-control" id="Priority">
                        @error('group_search_map_item.Priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> 
                    <div class="col-md-3 mb-3">
                        <label for="IsShowBothLocation">Show Both Location</label>
                        <select wire:model="group_search_map_item.IsShowBothLocation" class="form-control" id="IsShowBothLocation">
                            <option value="{{ null }}">please select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        @error('group_search_map_item.IsShowBothLocation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('group-search-map-item') }}" class="btn btn-secondary btn-icon-split">
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