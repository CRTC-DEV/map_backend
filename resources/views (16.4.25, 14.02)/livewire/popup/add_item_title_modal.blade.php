<!-- Add Itemtitle -->
    <div wire:ignore.self class="modal fade" id="itemTitleModal" tabindex="-1"
        aria-labelledby="itemTitleModalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemTitleModalModalLabel">Add ItemTitle Modal</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select name="ItemTiltle.TextContentId" wire:model="ItemTitle.TextContentId"
                        class="form-control mb-0 flex-grow-1" id="TitleId" aria-label="Title select example"
                        style="min-width: 200px;">
                        <option value="{{ null }}">Please select</option>
                        @foreach ($textcontent_titile as $item)
                            <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->OriginalText }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        wire:click="addItemtitle">Save
                        Item Tilte</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal ItemTitle -->