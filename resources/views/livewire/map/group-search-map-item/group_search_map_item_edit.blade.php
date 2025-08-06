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
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <label for="item_title" class="mb-0 me-3" style="white-space: nowrap; min-width: 150px;">
                        Group Search
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3 align-items-center">
                        <label for="item_title" class="mb-0 group-search">Group Search Name</label>
                        <div class="flex-grow-1 position-relative" style="min-width: 200px;">
                            <input type="hidden"wire:model="group_search_map_item.GroupSearchId">
                            <input TextContentId="group_search_map_item.GroupSearchId" wire:model.lazy="group_search.Name"class="form-control mb-0" id="GroupSearchId" aria-label="Gender select example">
                            @error('group_search.Name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 align-items-center">
                        <label for="item_title" class="mb-0 group-search ml-2">Group Search KeySearch</label>
                        <div class="flex-grow-1 position-relative" style="min-width: 200px;">
                            <input wire:model.lazy="group_search.KeySearch"class="form-control mb-0" id="GroupSearchId" aria-label="Gender select example">
                            @error('group_search.KeySearch')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 align-items-center">
                        <label for="item_title" class="mb-0 group-search ml-2">Group Search Priority</label>
                        <div class="flex-grow-1 position-relative" style="min-width: 200px;">
                            <input wire:model.lazy="group_search.Priority"class="form-control mb-0" id="GroupSearchId" aria-label="Gender select example">
                            @error('group_search.Priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 align-items-center">
                        <label for="item_title" class="mb-0 group-search ml-2">Group Search Rank</label>
                        <div class="flex-grow-1 position-relative" style="min-width: 200px;">
                            <input wire:model.lazy="group_search.Rank" class="form-control mb-0" id="GroupSearchId" aria-label="Gender select example">
                            @error('group_search.Rank')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 align-items-center">
                        <label for="item_title" class="mb-0 group-search ml-2">Group Search Description</label>
                        <div class="flex-grow-1 position-relative" style="min-width: 200px;">
                            <input wire:model.lazy="group_search.Description"
                                class="form-control mb-0" id="GroupSearchId" aria-label="Gender select example">
                            @error('group_search.Rank')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-4 mb-3 align-items-center">
                        <label for="item_title" class="mb-0 group-search ml-2">Group Search Title</label>
                        <div class="flex-grow-1 position-relative" style="min-width: 200px;">
                            <input wire:model.lazy="group_search.TitleId" type="hidden">
                            <input wire:model.lazy="item_title.Name"
                                class="form-control mb-0" id="GroupSearchId" aria-label="Gender select example">
                            @error('group_search.Title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="card card-body border-0 shadow mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="group_search_map_item.MapItemId">MapItem </label>
                        <a target="_blank" href="{{ route('map-item-edit', ['id' => $map_item_id]) }}" class="">
                            <span class="icon text-black" style="font-size: 0.8rem;">
                                <i class="fa fa-plus"></i>
                            </span>
                        </a>
                        <select TextContentId="group_search_map_item.MapItemId"
                            wire:model="group_search_map_item.MapItemId" class="form-control mb-0" id="MapItemId"
                            aria-label="Gender select example">

                            @foreach ($map_item as $item)
                                <option value="{{ $item->Id }}">{{ $item->CadId }} - {{ $item->TitleText }}</option>
                            @endforeach
                        </select>
                        @error('map_item.Id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="group_search_map_item.Status">Status </label>
                        <select TextContentId="group_search_map_item.Status" wire:model="group_search_map_item.Status"
                            class="form-control mb-0" id="Status" aria-label="Gender select example">

                            <option value="1">Disable</option>
                            <option value="2">Enable</option>
                        </select>
                        @error('group_search_map_item.Status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="Priority">Priority</label>
                        <input wire:model="group_search_map_item.Priority" class="form-control" id="Priority">
                        @error('group_search_map_item.Priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="IsShowBothLocation">Show Both Location</label>
                        <select wire:model="group_search_map_item.IsShowBothLocation" class="form-control" id="IsShowBothLocation">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        @error('group_search_map_item.IsShowBothLocation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="IsSearchAllFloor">Search All Floor</label>
                        <select wire:model="group_search_map_item.IsSearchAllFloor" class="form-control" id="IsSearchAllFloor">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        @error('group_search_map_item.IsSearchAllFloor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('group-search-map-item') }}" class="btn btn-secondary btn-icon-split">
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

                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger btn-icon-split mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Deleted</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
     @include('livewire.popup.delete', ['title' => 'Confirm Delete', 'emit' => "delete($this->group_search_id, $this->map_item_id)"])
</div>
@section('script')
<script>
$(document).ready(function() {
     $('#MapItemId').select2({
            placeholder: 'Search for a title...',
            allowClear: true,
            minimumResultsForSearch: 0, // Always show search box
        });

        // Ensure Livewire and Select2 work together
        $('#MapItemId').on('change', function (e) {
            var data = $('#MapItemId').select2("val");
            @this.set('group_search_map_item.MapItemId', data);
        });
});
</script>
@endsection