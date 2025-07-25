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
                        <input wire:model="item_type.Name" class="form-control" id="Name">
                        @error('item_type.Name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="Description">Description</label>
                        <input wire:model="item_type.Description" class="form-control" id="Description">
                        @error('item_type.Description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    
                    
                    <div class="col-md-3 mb-3">
                        <label for="item_type.Status">Status </label>
                        <select name="item_type.Status" wire:model="item_type.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('item_type.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="item_type.IsShow">IsShow </label>
                        <select name="item_type.IsShow" wire:model="item_type.IsShow" class="form-control mb-0" id="IsShow"
                            aria-label="Gender select example">                           
                            <option value="1">Show</option>
                            <option value="2">Hidden</option>
                        </select>
                        @error('item_type.IsShow') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('item-type') }}" class="btn btn-secondary btn-icon-split">
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