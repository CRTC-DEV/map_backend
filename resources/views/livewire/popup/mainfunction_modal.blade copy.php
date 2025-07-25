<!-- List mainfunctionTouchGroupFunction Modal -->
<div wire:ignore.self class="modal fade" id="listMainFunctionModal" tabindex="-1"
    aria-labelledby="listMainFunctionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listMainFunctionModalLabel">Add List Sub-Function</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             @if (Session::has('messages'))
                <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
                    {{ Session::get('messages') }}
                </div>
            @endif
                <div class=" d-flex">
                   
                    <!-- mainfunctionTouchScreen List -->
                    <div class="w-50 pl-2">
                        <h6>Sub Function</h6>
                        @foreach ($item_title as $item)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="selectedMainFunction"
                                    value="{{ $item->original->Id }}" id="item_title_{{ $item->original->Id }}">
                                <label class="form-check-label" for="item_title_{{ $item->original->Id }}">
                                    {{ $item->original->Id }} - {{ $item->original->OriginalText }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- GroupFunctionmainfunctionTouch Fields -->
                <fieldset class="col-md-12 mb-4 border p-3">
                    <legend>Sub Function Fields</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="linkStatus">Sub Function Status</label>
                            <select wire:model="mainfunction.Status" class="form-control" id="linkStatus">
                                <option value="">Select Link Status</option>
                                <option value="2">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                            @error('MainFunction.Status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>
                </fieldset>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click='insertlist' class="btn btn-primary" wire:click="saveSelections">Save
                    Selections</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal ListDeviceTouchGroupFunction -->
