<!-- List SignageMapItem Modal -->
<div wire:ignore.self class="modal fade" id="listSignageMapItemModal" tabindex="-1"
    aria-labelledby="listSignageMapItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listSignageMapItemModalLabel">List Signage Map Item</h5>
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
                    <!-- Signages List -->
                    <div class="w-50 pr-2 border-right">
                        <h6>Signages</h6>
                        @foreach ($Signage as $sign)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="selectedSignages"
                                    value="{{ $sign->Id }}" id="signage_{{ $sign->Id }}">
                                <label class="form-check-label" for="signage_{{ $sign->Id }}">
                                    {{ $sign->CadId }} - {{ $sign->title->textcontent->OriginalText }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <!-- MapItem List -->
                    <div class="w-50 pl-2">
                        <h6>Map Items</h6>
                        @foreach ($MapItem as $mapItem)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="selectedMapItems"
                                    value="{{ $mapItem->Id }}" id="mapitem_{{ $mapItem->Id }}">
                                <label class="form-check-label" for="mapitem_{{ $mapItem->Id }}">
                                    {{ $mapItem->Id }} - {{ $mapItem->TitleText ??'' }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- SignageMapItem Fields -->
                <fieldset class="col-md-12 mb-4 border p-3">
                    <legend>SignageMapItem Fields</legend>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="linkStatus">SignageMapItem Status</label>
                            <select wire:model="SignageMapItem.Status" class="form-control" id="linkStatus">
                                <option value="">Select Link Status</option>
                                <option value="2">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                            @error('SignageMapItem.Status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click='insertlist' class="btn btn-primary">Save Selections</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal ListSignageMapItem -->
