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
                    <!-- <div class="col-md-3 mb-3">
                        <label for="TextContentId">TextContentId</label>
                        <input wire:model="item_description.TextContentId" class="form-control" id="TextContentId">
                        @error('item_description.TextContentId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>                    -->
                    <div class="col-md-3 mb-3">
                        <label for="item_description.TextContentId">TextContent</label>
                        <select TextContentId="item_description.TextContentId" wire:model="item_description.TextContentId" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            @foreach ($text_content as $item)
                                <option value="{{$item->Id}}">{{$item->Id}} - {{$item->OriginalText}}</option>
                            @endforeach
                        </select>
                        @error('item_description.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="item_description.Status">Status </label>
                        <select name="item_description.Status" wire:model="item_description.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('item_description.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ guarded_route('item-description','admin.description') }}" class="btn btn-secondary btn-icon-split">
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