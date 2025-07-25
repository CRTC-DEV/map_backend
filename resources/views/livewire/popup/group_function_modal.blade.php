<!-- List mainfunctionTouchGroupFunction Modal -->
<div wire:ignore.self class="modal fade" id="listGroupFunctionModal" tabindex="-1"
    aria-labelledby="listGroupFunctionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listGroupFunctionModalLabel">Add Group-Function</h5>
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
                    <!-- GroupFunctions List -->
                    <div class="w-100 pr-2 border-right">
                        <h6>GroupFunctions</h6>
                        @foreach ($item_title as $title)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="selectedGroupFunctions"
                                    value="{{ $title->Id }}" id="groupfunction_{{ $title->Id }}">
                                <label class="form-check-label" for="groupfunction_{{ $title->Id }}">
                                    {{ $title->Id }} - {{ $title->OriginalText }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- GroupFunctionmainfunctionTouch Fields -->
                <fieldset class="col-md-12 mb-4 border p-3">
                    <legend>GroupFunction Fields</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="linkStatus">GroupFunction Status</label>
                            <select wire:model="GroupFunction.Status" class="form-control" id="linkStatus">
                                <option value="">Select Link Status</option>
                                <option value="2">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                            @error('GroupFunction.Status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="linkStatus">GroupFunction IconUrl</label>
                            <input wire:model="GroupFunction.IconUrl" class="form-control" id="linkStatus">
                            @error('GroupFunction.IconUrl')
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
