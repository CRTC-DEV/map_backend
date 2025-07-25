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
                        <label for="item_title" class="mb-0 me-3" style="white-space: nowrap; min-width: 150px;">
                            Title Map Item
                        </label>
                    </div>
                    <div class="col-md-12 mb-3 d-flex align-items-center">
                        <label for="item_title" class="mb-0"
                            style="white-space: nowrap; min-width: 150px; margin-right: 20px;">
                            Edit Title Text
                        </label>
                        <div class="flex-grow-1 position-relative" style="min-width: 200px;">
                            <input wire:model.defer="item_title.Text" class="form-control" id="item_title"
                                style="width: 100%;">
                            @error('item_title.Text')
                                <div class="invalid-feedback d-block position-absolute" style="top: 100%; left: 0;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <a wire:click="editTitleTextContent" class="btn btn-sm btn-circle btn-primary"
                            style="margin-left: 10px;">
                            <span class="icon text-white">
                                <i class="fa fa-plus"></i>
                            </span>
                        </a>
                    </div>
                    @if ($translation_title)
                        @foreach ($translation_title as $key => $trans)
                            <div class="col-md-12 mb-3 d-flex align-items-center">
                                <label for="title_text_{{ $trans->TextContentId }}_{{ $trans->LanguageId }}"
                                    class="mb-0" style="white-space: nowrap; min-width: 150px; margin-right: 20px;">
                                    Translation {{ $trans->Name }}
                                </label>
                                <input type="text" class="form-control"
                                    id="title_text_{{ $trans->TextContentId }}_{{ $trans->LanguageId }}"
                                    style="width: 100%;" value="{{ $trans->Translation }}"
                                    wire:keydown.enter="editTranslation('{{ $trans->TextContentId }}', '{{ $trans->LanguageId }}', this.value)"
                                    oninput="this.setAttribute('data-value', this.value)">
                                <a wire:click="editTranslationTitle('{{ $trans->TextContentId }}', '{{ $trans->LanguageId }}', document.getElementById('title_text_{{ $trans->TextContentId }}_{{ $trans->LanguageId }}').value)"
                                    class="btn btn-sm btn-circle btn-primary" style="margin-left: 10px;">
                                    <span class="icon text-white">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                </a>
                            </div>
                        @endforeach
                        <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="title_text" class="mb-0"
                                style="white-space: nowrap; min-width: 150px; margin-right: 20px;">Add
                                Translation for Another Languages</label>
                            <a wire:click="addTranslationTitle" class="btn btn-sm btn-circle btn-primary"
                                style="margin-left: 10px;">
                                <span class="icon text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                        </div>
                    @else
                        <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="title_text" class="mb-0"
                                style="white-space: nowrap; min-width: 150px; margin-right: 20px;">Add
                                Translation</label>
                            <a wire:click="addTranslationTitle" class="btn btn-sm btn-circle btn-primary"
                                style="margin-left: 10px;">
                                <span class="icon text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card card-body border-0 shadow mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="CadId">CadId</label>
                            <input wire:model.defer="map_item.CadId" class="form-control" id="CadId">
                            @error('map_item.CadId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="Longitudes">Longitudes</label>
                            <input wire:model.defer="map_item.Longitudes" class="form-control" id="Longitudes">
                            @error('map_item.Longitudes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="Latitudes">Latitudes</label>
                            <input wire:model.defer="map_item.Latitudes" class="form-control" id="latitudes">
                            @error('map_item.Latitudes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="map_item.Status">Status </label>
                            <select name="map_item.Status" wire:model.defer="map_item.Status" class="form-control mb-0"
                                id="Status" aria-label="Gender select example">
                                <option value="{{ null }}">Please select</option>
                                <option value="1">Disable</option>
                                <option value="2">Enable</option>
                            </select>
                            @error('map_item.Status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="map_item.AreaSide">Area Side </label>
                            <select name="map_item.AreaSide" wire:model.defer="map_item.AreaSide" class="form-control mb-0"
                                id="AreaSide" aria-label="Gender select example">
                                <option value="{{1}}">LandSide</option>
                                <option value="{{2}}">AirSide</option>
                            </select>
                            @error('map_item.AreaSide')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="map_item.Rank">Rank</label>
                            <input wire:model.defer="map_item.Rank" class="form-control" id="Rank">
                            @error('map_item.Rank')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-12">
                            <label for="keysearch">Key Search</label>
                            <input wire:model.defer="map_item.KeySearch" class="form-control" id="keysearch">
                            @error('map_item.KeySearch')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-6">
                            <label for="map_item.StoreHours">StoreHours</label>
                            <input wire:model.defer="map_item.StoreHours" class="form-control" id="StoreHours">
                            @error('map_item.StoreHours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="col-md-6 mb-6">
                            <label for="map_item.Contact">Contact</label>
                            <input wire:model.defer="map_item.Contact" class="form-control" id="Contact">
                            @error('map_item.Contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="ImgUrl">Image</label>
                            <div>
                                @if($map_item->ImgUrl)
                                    <div class="mb-2">
                                        <img src="{{ asset($map_item->ImgUrl) }}" alt="Current image" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                @endif
                                <input wire:model="image" type="file" class="form-control" id="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-body border-0 shadow mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="map_item.T2location">T2Location</label>
                            <input wire:model.defer="map_item.T2LocationId" class="form-control" id="item_title"
                                style="width: 100%;" type="hidden">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label for="CadId">Name</label>
                                    <input wire:model.defer="t2location.Name" class="form-control" id="CadId">
                                    @error('t2location.Name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="CadId">Zone</label>
                                    <input wire:model.defer="t2location.Zone" class="form-control" id="CadId">
                                    @error('t2location.Zone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="CadId">Floor</label>
                                    <input wire:model.defer="t2location.Floor" class="form-control" id="CadId">
                                    @error('t2location.Floor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-between">
                                <a wire:click="editT2location" class="btn btn-primary btn-icon-split btn-submit"
                                    style="margin-left: 10px;">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                    <span class="text">Update T2 Location</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-body border-0 shadow mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="map_item.Status">Item Type</label>
                            <div class="col-md-12 mb-3">
                                <input wire:model.defer="map_item.ItemTypeId" class="form-control" id="item_title"
                                    style="width: 100%;" type="hidden">
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label for="CadId">Name</label>
                                        <input wire:model.defer="item_type.Name" class="form-control" id="CadId">
                                        @error('item_type.Name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="CadId">Description</label>
                                        <input wire:model.defer="item_type.Description" class="form-control"
                                            id="Description">
                                        @error('item_type.Description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="CadId">IsShow</label>
                                        <select name="item_type.IsShow" wire:model.defer="item_type.IsShow"
                                            class="form-control">
                                            <option value="1" selected>Show</option>
                                            <option value="2" selected>Hide</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3 d-flex justify-content-between">
                                    <a wire:click="editItemType" class="btn btn-primary btn-icon-split btn-submit"
                                        style="margin-left: 10px;">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-right"></i>
                                        </span>
                                        <span class="text">Update Item Type</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-body border-0 shadow mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <label for="item_description" class="mb-0 me-3"
                            style="white-space: nowrap; min-width: 150px;">
                            Map Item Description
                        </label>
                    </div>
                    <div class="col-md-12 mb-3 d-flex align-items-center">
                        <label for="item_description" class="mb-0"
                            style="white-space: nowrap; min-width: 150px; margin-right: 20px;">
                            Edit Description Text
                        </label>
                        <div class="flex-grow-1 position-relative" style="min-width: 200px;">
                            <textarea wire:model.defer="description.Text" class="form-control" id="item_description" style="width: 100%;"> </textarea>
                            @error('description.Text')
                                <div class="invalid-feedback d-block position-absolute" style="top: 100%; left: 0;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <a wire:click="editItemDescriptionTextContent" class="btn btn-sm btn-circle btn-primary"
                            style="margin-left: 10px;">
                            <span class="icon text-white">
                                <i class="fa fa-plus"></i>
                            </span>
                        </a>
                    </div>
                    @if ($translation_des)
                        @foreach ($translation_des as $key => $trans)
                            <div class="col-md-12 mb-3 d-flex align-items-center">
                                <label for="title_text_{{ $trans->TextContentId }}_{{ $trans->LanguageId }}"
                                    class="mb-0" style="white-space: nowrap; min-width: 150px; margin-right: 20px;">
                                    Translation {{ $trans->Name }}
                                </label>
                                <textarea class="form-control" id="title_text_{{ $trans->TextContentId }}_{{ $trans->LanguageId }}"
                                    style="width: 100%;"
                                    wire:keydown.enter="editTranslation('{{ $trans->TextContentId }}', '{{ $trans->LanguageId }}', this.value)"
                                    oninput="this.setAttribute('data-value', this.value)">{{ $trans->Translation }}</textarea>
                                <a wire:click="editTranslationItemDescription('{{ $trans->TextContentId }}', '{{ $trans->LanguageId }}', document.getElementById('title_text_{{ $trans->TextContentId }}_{{ $trans->LanguageId }}').value)"
                                    class="btn btn-sm btn-circle btn-primary" style="margin-left: 10px;">
                                    <span class="icon text-white">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                </a>
                            </div>
                        @endforeach
                        <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="title_text" class="mb-0"
                                style="white-space: nowrap; min-width: 150px; margin-right: 20px;">Add
                                Translation for Another Languages</label>
                            <a wire:click="addTranslationDescription" class="btn btn-sm btn-circle btn-primary"
                                style="margin-left: 10px;">
                                <span class="icon text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                        </div>
                    @else
                        <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="title_text" class="mb-0"
                                style="white-space: nowrap; min-width: 150px; margin-right: 20px;">Add
                                Translation</label>
                            <a wire:click="addTranslationDescription" class="btn btn-sm btn-circle btn-primary"
                                style="margin-left: 10px;">
                                <span class="icon text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('map-item') }}" class="btn btn-secondary btn-icon-split">
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
    @include('livewire.popup.add_translation_title_modal')
    @include('livewire.popup.translation_description_modal')

</div>
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chọn tất cả các nút có class "edit-translation"
            const buttons = document.querySelectorAll('.edit-translation');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    // Lấy giá trị từ ô nhập liệu
                    const input = this.previousElementSibling; // Ô nhập liệu nằm ngay trước nút
                    const translation = input.value;
                    const textContentId = input.getAttribute('data-text-content-id');
                    const languageId = input.getAttribute('data-language-id');

                    // Gọi hàm Livewire và truyền tham số
                    @this.editTranslation(textContentId, languageId, translation);
                });
            });
        });

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
    </script>
@endsection
