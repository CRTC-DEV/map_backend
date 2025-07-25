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
                <div class="card card-body border-0 shadow mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <label for="title_text" class="mb-0 me-3" style="white-space: nowrap; min-width: 150px;">
                            Title Map Item
                        </label>
                    </div>
                    <div class="col-md-12 mb-3 d-flex align-items-center">
                        <label for="title_text" class="mb-0"
                            style="white-space: nowrap; min-width: 150px; margin-right: 20px;">
                            Add Title Text
                        </label>
                        <div class="flex-grow-1 position-relative" style="min-width: 200px;">
                            <input wire:model="title_text.OriginalText" class="form-control" id="title_text"
                                style="width: 100%;">
                            @error('title_text.OriginalText')
                                <div class="invalid-feedback d-block position-absolute" style="top: 100%; left: 0;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <select name="title_text.OriginalLanguageId" wire:model="title_text.OriginalLanguageId"
                                class="form-control form-select-sm" aria-label="Language select"
                                style="min-width: 80px;">
                                @foreach ($language as $lang)
                                    <option value="{{ $lang->Id }}" selected>{{ $lang->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <a wire:click="addTitleTextContent" class="btn btn-sm btn-circle btn-primary"
                            style="margin-left: 10px;">
                            <span class="icon text-white">
                                <i class="fa fa-plus"></i>
                            </span>
                        </a>
                    </div><br>
                    @if ($showTranslationInput)
                        <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="title_text" class="mb-0"
                                style="white-space: nowrap; min-width: 150px; margin-right: 20px;">Add
                                Translation</label>
                            <input wire:model="title_text.OriginalText" class="form-control" id="title_text"
                                style="width: 100%;" disabled>
                            <a wire:click="addTranslation" class="btn btn-sm btn-circle btn-primary"
                                style="margin-left: 10px;">
                                <span class="icon text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                        </div>
                    @endif
                    <div class="col-md-12 mb-3 d-flex align-items-center">
                        <label for="TitleId" class="mb-0"
                            style="white-space: nowrap; min-width: 150px; margin-right: 20px;">Choose Title Map
                            Item</label>
                        <select name="map_item.TitleId" wire:model="map_item.TitleId"
                            class="form-control mb-0 flex-grow-1" id="TitleId" aria-label="Title select example"
                            style="min-width: 200px;">
                            <option value="{{ null }}">Please select</option>
                            @foreach ($item_title as $item)
                                <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->OriginalText }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('map_item.TitleId')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="card card-body border-0 shadow mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="CadId">CadId</label>
                            <input wire:model="map_item.CadId" class="form-control" id="CadId">
                            @error('map_item.CadId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="Longitudes">Longitudes</label>
                            <input wire:model="map_item.Longitudes" class="form-control" id="Longitudes">
                            @error('map_item.Longitudes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="Latitudes">Latitudes</label>
                            <input wire:model="map_item.Latitudes" class="form-control" id="latitudes">
                            @error('map_item.Latitudes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="map_item.AreaSide">AreaSide </label>
                            <select name="map_item.AreaSide" wire:model="map_item.AreaSide" class="form-control mb-0"
                                id="AreaSide" aria-label="Gender select example">
                                <option value="{{ null }}">please select</option>
                                <option value="1">LandSide</option>
                                <option value="2">AirSide</option>
                            </select>
                            @error('map_item.AreaSide')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-12">
                            <label for="keysearch">Key Search</label>
                            <input wire:model="map_item.KeySearch" class="form-control" id="keysearch">
                            @error('map_item.KeySearch')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="col-md-3 mb-3">
                            <label for="map_item.Rank">Rank</label>
                            <input wire:model="map_item.Rank" class="form-control" id="Rank">
                            @error('map_item.Rank')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="map_item.Status">Status </label>
                            <select name="map_item.Status" wire:model="map_item.Status" class="form-control mb-0"
                                id="Status" aria-label="Gender select example">
                                <option value="{{ null }}">Please select</option>
                                <option value="1">Disable</option>
                                <option value="2">Enable</option>
                            </select>
                            @error('map_item.Status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="col-md-6 mb-6">
                            <label for="map_item.StoreHours">StoreHours</label>
                            <input wire:model="map_item.StoreHours" class="form-control" id="StoreHours">
                            @error('map_item.StoreHours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="col-md-6 mb-6">
                            <label for="map_item.Contact">Contact</label>
                            <input wire:model="map_item.Contact" class="form-control" id="Contact">
                            @error('map_item.Contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="ImgUrl">Image</label>
                            <input wire:model="image" type="file" class="form-control" id="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card card-body border-0 shadow mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="map_item.Status">T2Location</label>
                            <a wire:click="addT2location" class="btn btn-sm btn-circle btn-primary"
                                style="margin-left: 10px;">
                                <span class="icon text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                            <select name="map_item.T2LocationId" wire:model="map_item.T2LocationId"
                                class="form-control mb-0" id="Status" aria-label="Gender select example">
                                <option value="{{ null }}">Please select</option>
                                @foreach ($t2location as $t2)
                                    <option value="{{ $t2->Id }}">{{ $t2->Id }} - {{ $t2->Name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('map_item.T2LocationId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card card-body border-0 shadow mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="map_item.Status">Item Type</label>
                            <a wire:click="addItemType" class="btn btn-sm btn-circle btn-primary"
                                style="margin-left: 10px;">
                                <span class="icon text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                            <select name="map_item.ItemTypeId" wire:model="map_item.ItemTypeId"
                                class="form-control mb-0" id="Status" aria-label="Gender select example">
                                <option value="{{ null }}">Please select</option>
                                @foreach ($item_type as $type)
                                    <option value="{{ $type->Id }}">{{ $type->Id }} - {{ $type->Name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('map_item.ItemTypeId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card card-body border-0 shadow mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <label for="description_text" class="mb-0 me-3"
                            style="white-space: nowrap; min-width: 150px;">
                            Map Item Description
                        </label>
                        <div>
                            <select name="description_text.OriginalLanguageId"
                                wire:model="description_text.OriginalLanguageId" class="form-control form-select-sm"
                                aria-label="Language select" style="min-width: 80px;">
                                @foreach ($language as $lang)
                                    <option value="{{ $lang->Id }}" selected>{{ $lang->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3 d-flex align-items-center">
                        <label for="description_text" class="mb-0"
                            style="white-space: nowrap; min-width: 150px; margin-right: 20px;">
                            Add Description Text
                        </label>
                        <div class="flex-grow-1 position-relative" style="min-width: 200px;" >
                            <textarea wire:model="description_text.OriginalText" class="form-control" id="description_text"
                                style="width: 100%;"></textarea>
                            @error('description_text.OriginalText')
                                <div class="invalid-feedback d-block position-absolute" style="top: 100%; left: 0;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <a wire:click="addDescription" class="btn btn-sm btn-circle btn-primary"
                            style="margin-left: 10px;">
                            <span class="icon text-white">
                                <i class="fa fa-plus"></i>
                            </span>
                        </a>
                    </div><br>
                    @if ($showTranslationDescripton)
                        <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="description_text" class="mb-0"
                                style="white-space: nowrap; min-width: 150px; margin-right: 20px;">Add
                                Translation</label>
                            <input wire:model="description_text.OriginalText" class="form-control"
                                id="description_text" style="width: 100%;" disabled>
                            <a wire:click="addTranslationDescription" class="btn btn-sm btn-circle btn-primary"
                                style="margin-left: 10px;">
                                <span class="icon text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                        </div>
                    @endif
                    <div class="col-md-12 mb-3 d-flex align-items-center">
                        <label for="DescriptionId" class="mb-0"
                            style="white-space: nowrap; min-width: 150px; margin-right: 20px;">Choose Description
                            </label>
                        <select name="map_item.DescriptionId" wire:model="map_item.DescriptionId"
                            class="form-control mb-0 flex-grow-1" id="DescriptionId" aria-label="Title select example"
                            style="min-width: 200px;">
                            <option value="{{ null }}">Please select</option>
                            @foreach ($description as $item)
                                <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->OriginalText }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('map_item.DescriptionId')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('map-item') }}" class="btn btn-secondary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span>
                        </a>
                        <button type="submit" class="btn btn-primary btn-icon-split btn-submit">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Add Item</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @if (Session::has('message'))
        <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    @include('livewire.popup.add_translation_title_modal')
    @include('livewire.popup.add_item_title_modal')
    @include('livewire.popup.add_description_item_modal')
    @include('livewire.popup.t2_location_modal')
    @include('livewire.popup.translation_description_modal')
    @include('livewire.popup.add_item_type_modal')
</div>
@section('script')
    <script>
        //Transalation
        document.addEventListener('livewire:load', function() {
            Livewire.on('openTranslationModal', (originalText) => {
                $('#translationModal').modal('show'); // Assuming Bootstrap modal
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('closeTranslationModal', () => {
                $('#translationModal').modal('hide');
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('openTranslationDescriptionModal', (originalText) => {
                $('#TranslationDescriptionModal').modal('show'); // Assuming Bootstrap modal
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('closeTranslationDescriptionModal', () => {
                $('#TranslationDescriptionModal').modal('hide');
            });
        });
        //ItemTitle
        document.addEventListener('livewire:load', function() {
            Livewire.on('openItemTitleModal', () => {
                $('#itemTitleModal').modal('show'); // Assuming Bootstrap modal
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('closeItemTitleModal', () => {
                $('#itemTitleModal').modal('hide');
            });
        });
        //Description
        document.addEventListener('livewire:load', function() {
            Livewire.on('openDescriptionModal', () => {
                $('#itemDescriptionModal').modal('show'); // Assuming Bootstrap modal
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('closeItemTitleModal', () => {
                $('#itemDescriptionModal').modal('hide');
            });
        });

        document.addEventListener('livewire:load', function() {
            Livewire.on('openT2locationModal', function() {
                $('#t2locationModal').modal('show');
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('closeT2locationModal', function() {
                $('#t2locationModal').modal('hide');
            });
        });
        //Itemtype
        document.addEventListener('livewire:load', function() {
            Livewire.on('openItemTypeModal', function() {
                $('#itemTypeModal').modal('show');
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('closeItemTypeModal', function() {
                $('#itemTypeModal').modal('hide');
            });
        });
    </script>
@endsection
