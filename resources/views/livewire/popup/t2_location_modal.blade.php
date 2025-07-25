<!-- resources/views/components/t2location-modal.blade.php -->
<div wire:ignore.self class="modal fade" id="t2locationModal" tabindex="-1" aria-labelledby="t2locationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80%; margin: auto;">
        <div class="modal-content">
            @if (Session::has('message'))
                <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="modal-header">
                <h5 class="modal-title" id="t2locationModalLabel">Add T2 Location</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="StartMapItemId">Name</label>
                        <input wire:model="t2_location_add.Name" class="form-control" id="TitleId">
                        @error('t2_location_add.Name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="CadId">Zone</label>
                        <input wire:model="t2_location_add.Zone" class="form-control" id="CadId">
                        @error('t2_location_add.Zone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="CadId">Floor</label>
                        <input wire:model="t2_location_add.Floor" class="form-control" id="CadId">
                        @error('t2_location_add.Floor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="map_item.Status">Status </label>
                        <select name="t2_location_add.Status" wire:model="t2_location_add.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">Please select</option>
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('t2_location_add.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" wire:click="insertT2location">Save
                    T2 Location</button>
            </div>
        </div>
    </div>
</div>
