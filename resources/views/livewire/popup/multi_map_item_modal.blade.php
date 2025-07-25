<!-- Multi Map Item Modal -->
<div wire:ignore.self class="modal fade" id="multiMapItemModal" tabindex="-1"
    aria-labelledby="multiMapItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="multiMapItemModalLabel">Add Multiple Map Items to Group Search</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (Session::has('messages'))
                    <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
                        {{ Session::get('messages') }}
                    </div>
                @endif
                
                <!-- Select Group Search -->
                <div class="form-group mb-4">
                    <label for="selectedGroupSearch">Select Group Search</label>
                    <select wire:model="selectedGroupSearch" class="form-control mb-0" id="selectedGroupSearch">
                        <option value="">Please select</option>
                        @foreach($group_search as $item)
                            <option value="{{ $item->Id }}">{{ $item->Id }}-{{ $item->Name }}|{{ $item->KeySearch }}</option>
                        @endforeach
                    </select>
                    @error('selectedGroupSearch') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                
                <!-- Common Settings -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="multiStatus">Status</label>
                            <select wire:model="multiSettings.Status" class="form-control" id="multiStatus">
                                <option value="">Please select</option>
                                <option value="1">Disable</option>
                                <option value="2">Enable</option>
                            </select>
                            @error('multiSettings.Status') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="multiShowBothLocation">Show Both Location</label>
                            <select wire:model="multiSettings.IsShowBothLocation" class="form-control" id="multiShowBothLocation">
                                <option value="">Please select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('multiSettings.IsShowBothLocation') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="multiSearchAllFloor">Search All Floor</label>
                            <select wire:model="multiSettings.IsSearchAllFloor" class="form-control" id="multiSearchAllFloor">
                                <option value="">Please select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('multiSettings.IsSearchAllFloor') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- Search Box for Map Items -->
                <div class="form-group mb-4">
                    <label for="searchMapItems">Search Map Items</label>
                    <div class="input-group">
                        <input wire:model.debounce.300ms="searchMapItem" type="text" class="form-control" id="searchMapItems" placeholder="Search by CadId or KeySearch...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Map Items List -->
                <div class="form-group" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th width="40px"></th>
                                <th>CadId</th>
                                <th>KeySearch</th>
                                <th width="100px">Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($filteredMapItems as $item)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="selectedMapItems" 
                                            value="{{ $item->Id }}" 
                                            id="map_item_{{ $item->Id }}">
                                    </div>
                                </td>
                                <td>{{ $item->CadId }}</td>
                                <td>{{ $item->KeySearch }}</td>
                                <td>
                                    <input type="number" 
                                        class="form-control form-control-sm" 
                                        wire:model="mapItemPriorities.{{ $item->Id }}"
                                        placeholder="Priority"
                                        min="0">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No map items found. Try another search term.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button wire:click="saveMultipleMapItems" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Map Items
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Multi Map Item -->
