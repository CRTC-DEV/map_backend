<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Add Connect Businesses</h1>
            {{-- <button wire:click='opensavelist' class="btn btn-primary btn-icon-split btn-submit">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">Add Device Touch GroupFunction</span>
            </button> --}}
        </div>
    </div>
    @if (Session::has('message'))
        <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div wire:key="form-add" class="mb-5">
        <form wire:submit.prevent="save" enctype="multipart/form-data">
            {{-- Data info --}}
            <div class="card card-body border-0 shadow mb-4">
                <div class="row">
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>Title Fields</legend>
                        <div class="row">
                         
                            <div class="col-md-12 mb-3">
                                <label for="ConnectBusinesses.Title">Title</label>
                                <input name="ConnectBusinesses.Title" wire:model.defer="ConnectBusinesses.Title"
                                    class="form-control mb-0 flex-grow-1" id="TitleId"
                                    aria-label="Title select example" style="min-width: 200px;">
                                @error('ConnectBusinesses.Title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="linkStatus">Submenu *</label>
                                <select wire:model.defer="ConnectBusinesses.SubMenuId" class="form-control" id="linkStatus">
                                    <option value="" selected>Select Submenu</option>
                                    @foreach ($available_submenu as $submenu)
                                        <option value="{{ $submenu->Id }}">{{ $submenu->Id }} -
                                            {{ $submenu->title->textcontent->OriginalText ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('ConnectBusinesses.SubMenuId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <!-- DeviceTouchScreen Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <div wire:ignore class="row">
                            <div class="col-md-12 mb-3">
                                <label for="selectedDevices">Description</label>
                                <textarea name="editor" class="form-control mb-0 flex-grow-1 " wire:model.lazy="ConnectBusinesses.Description"
                                    id="editor" aria-label="Title select example" style="min-width: 200px;">
                                </textarea>
                                @error('ConnectBusinesses.Description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <!-- ConnectBusinesses Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        {{-- <legend>ConnectBusinesses Fields</legend> --}}
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="File">Upload PDF File</label>
                                <input type="file" wire:model.defer="File" id="File"
                                    accept="application/pdf">
                                @error('File')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="ImagePath">Upload Image</label>
                                <div class="upload-template" style="width: 100%;">
                                    @if ($ImagePath)
                                        <img width="200px" src="{{ $ImagePath->temporaryUrl() }}"
                                            style="margin-right: 10px; margin-bottom: 10px;">
                                    @endif
                                    <input type="file" id="ImagePath" wire:model.defer="ImagePath" accept="image/*">
                                </div>
                                @error('ImagePath')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="error-message-ImagePath" class="invalid-message"></div>
                            </div>
                            {{-- <div class="col-md-3 mb-3">
                                <label for="orderIndex">ConnectBusinesses Banner</label>
                                <input wire:model.defer.defer="ConnectBusinesses.Banner" class="form-control" id="Banner"
                                    placeholder="Enter Order Index">
                                @error('ConnectBusinesses.Banner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="col-md-3 mb-3">
                                <label for="linkStatus">ConnectBusinesses Status</label>
                                <select wire:model.defer="ConnectBusinesses.Status" class="form-control" id="linkStatus">
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('ConnectBusinesses.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                           
                        </div>
                        <div wire:ignore class="form-group row">

                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('admin.connect.business') }}" class="btn btn-secondary btn-icon-split">
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
    {{-- @include('livewire.popup.groupfunction_devicetouch_modal') --}}
</div>
@section('script')
    <script>
        //Transalation
        document.addEventListener('livewire:load', function() {
            Livewire.on('openListDeviceTouchGroupFunction', (originalText) => {
                $('#listDeviceTouchGroupFunctionModal').modal('show'); // Assuming Bootstrap modal
            });
        });
    </script>
    <script>
        const editor = CKEDITOR.replace('editor');
        editor.on('change', function(event){
            @this.set('editor', event.editor.getData());
        })
    </script>
@endsection
