<!-- resources/views/components/Itemtype-modal.blade.php -->
<div wire:ignore.self class="modal fade" id="itemTypeModal" tabindex="-1" aria-labelledby="ItemtypeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80%; margin: auto;">
        <div class="modal-content">
            @if (Session::has('message'))
                <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="modal-header">
                <h5 class="modal-title" id="ItemtypeModalLabel">Add T2 Location</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="StartMapItemId">Name</label>
                        <input wire:model="item_type_add.Name" class="form-control" id="TitleId">
                        @error('item_type_add.Name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="map_item.Status">Status </label>
                        <select name="item_type_add.Status" wire:model="item_type_add.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">Please select</option>
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('item_type_add.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                   
                </div>
                <div class="col">
                        <label for="Description">Description</label>
                        <textarea wire:model="item_type_add.Description" class="form-control" id="Description"></textarea>
                        @error('item_type_add.Description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" wire:click="insertItemtype">Save
                    T2 Location</button>
            </div>
        </div>
    </div>
</div>
