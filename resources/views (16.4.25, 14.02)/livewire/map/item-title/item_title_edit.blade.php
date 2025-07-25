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
                        <input wire:model="item_title.TextContentId" class="form-control" id="TitlTextContentIdeId">
                        @error('item_title.TextContentId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> -->
                    <div class="col-md-3 mb-3">
                        <label for="item_title.TextContentId">TextContent</label>
                        <select name="item_title.TextContentId" wire:model="item_title.TextContentId" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            @foreach($textcontent as $txt)
                                <option value="{{$txt->Id}}" >TextContentId ({{$txt->Id}}) - {{$txt->OriginalText}}</option>
                            @endforeach
                        </select>
                        @error('item_title.TextContentId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="item_title.Type">Type </label>
                        <select name="item_title.Type" wire:model="item_title.Type" class="form-control mb-0" id="Type"
                            aria-label="Gender select example">                           
                             <option value="{{MAP_ITEM}}" >Map Item</option>
                            <option value="{{SIGNAGE}}" >Signage</option>
                            <option value="{{MAINFUNCTION}}" >Sub Function</option>
                            <option value="{{GROUP_FUNCTION}}" >Group Function</option>
                            <option value="{{ ADV }}" >Advertisement</option>
                            <option value="{{ EVENT }}" >Event</option>
                            <option value="{{ FAQTYPE }}" >Faq Type</option>
                            <option value="{{ FAQ }}" >Faq</option>
                            <option value="{{ CONTACTNUMBERTYPE }}" >Contact Number Type</option>
                            <option value="{{ TOPMENU }}" >Top Menu</option>
                            <option value="{{ SUBMENU }}" >Sub Menu</option>
                           
                        </select>
                        @error('item_title.Type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                   
                    <div class="col-md-3 mb-3">
                        <label for="item_title.Status">Status </label>
                        <select name="item_title.Status" wire:model="item_title.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            <option value="1">Disable</option>
                            <option value="2">Enable</option>
                        </select>
                        @error('item_title.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ guarded_route('item-title','admin.title') }}" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                    <div class="ml-auto d-flex">
                        <a wire:click="delete" class="btn btn-danger btn-icon-split mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Deleted</span>
                        </a>
                        <button type="submit" class="btn btn-primary btn-icon-split btn-submit">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Update Item</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>