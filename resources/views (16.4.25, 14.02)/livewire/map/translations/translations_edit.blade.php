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
                        <label for="map_item.Status">TextContent</label>
                        <select name="translations.TextContentId" wire:model="translations.TextContentId" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <!-- <option value="{{$translations->TextContentId}}">{{$translations->OriginalText}}</option> -->
                            @foreach($text_content as $item)
                                <option value="{{$item->Id}}" >{{$item->Id}} - {{$item->OriginalText}}</option>
                            @endforeach
                        </select>
                        @error('translations.TextContentId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="map_item.Status">Language</label>
                        <select name="translations.LanguageId" wire:model="translations.LanguageId" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <!-- <option value="{{$translations->LanguageId}}" selected>{{$translations->Name}}</option> -->
                            @foreach($languages as $item)
                                <option value="{{$item->Id}}" >{{$item->Id}} - {{$item->Name}}</option>
                            @endforeach
                        </select>
                        @error('translations.LanguageId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="map_item.Status">Status </label>
                        <select name="translations.Status" wire:model="translations.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('translations.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col">
                    <label for="CadId">Translation</label>
                    <textarea wire:model.defer="translations.Translation" class="form-control" id="CadId" style="height:300px;"></textarea>
                    @error('translations.Translation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ guarded_route('translations','admin.translations') }}" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                    <div class="ml-auto d-flex">
                        <!-- <a wire:click="delete" class="btn btn-danger btn-icon-split mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Deleted</span>
                        </a> -->
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