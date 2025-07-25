<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Edit Connect Businesses</h1>
        </div>
    </div>
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
                                <select wire:model.defer="ConnectBusinesses.SubMenuId" class="form-control"
                                    id="linkStatus">
                                    <option value="" selected>Select Submenu</option>
                                    @foreach ($available_submenu as $submenu)
                                    <option value="{{ $submenu->Id }}">{{ $submenu->Id }} -
                                        {{ $submenu->title->textcontent->OriginalText ?? '' }}
                                    </option>
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

                                <textarea name="editor" class="form-control mb-0 flex-grow-1" wire:model.defer="ConnectBusinesses.Description"

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
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="File">Upload PDF File</label>

                                @if ($ConnectBusinesses['File'])
                                <div>
                                    <a href="{{ asset('storage/' . $ConnectBusinesses['File']) }}" target="_blank">
                                        {{ basename($ConnectBusinesses['File']) }}
                                    </a>
                                    {{-- <button type="button" wire:click="removeFile"
                                            class="btn btn-sm btn-danger">Remove</button> --}}
                                </div>
                                @endif

                                <input type="file" wire:model.defer="File" id="File" accept="application/pdf">

                                @error('File')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="ImagePath">Upload Image</label>
                                <div class="upload-template" style="width: 100%;">
                                    <!-- Show existing image from database -->
                                    @if ($ConnectBusinesses['Banner'])
                                        @if($ConnectBusinesses['Banner'] == $ImagePath)
                                            <img width="200px" src="{{ asset($ConnectBusinesses['Banner']) }}"
                                                style="margin-right: 10px; margin-bottom: 10px;">
                                        @else
                                            <div wire:loading.remove wire:target="ImagePath">
                                                @if ($ImagePath instanceof \Livewire\TemporaryUploadedFile)
                                                    <img width="200px" src="{{ $ImagePath->temporaryUrl() }}"
                                                        style="margin-right: 10px; margin-bottom: 10px;">
                                                @endif
                                            </div>
                                        @endif
                                    @endif

                                    <!-- Live preview for newly selected image -->
                                    

                                    <input type="file" id="ImagePath" wire:model="ImagePath" accept="image/*"
                                        class="@error('ImagePath') is-invalid @enderror">
                                </div>

                                @error('ImagePath')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                           
                            <div class="col-md-3 mb-3">
                                <label for="linkStatus">ConnectBusinesses Status</label>
                                <select wire:model.defer="ConnectBusinesses.Status" class="form-control"
                                    id="linkStatus">
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('ConnectBusinesses.Status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('admin.connect.business') }}" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                    <div class="ml-auto d-flex">
                        <button type="submit" class="btn btn-primary btn-icon-split btn-submit mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Update Item</span>
                        </button>
                        <a wire:click="delete" class="btn btn-danger btn-icon-split mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Deleted</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@section('script')
<script>
    document.addEventListener('livewire:load', function() {

        CKEDITOR_CONFIGS = {
            'default': {
                'versionCheck': False
            }
        }



        flatpickr('#startDateInput', {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        flatpickr('#expiryDateInput', {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    });
</script>



    <script>
        const editor = CKEDITOR.replace('editor');
        editor.on('change', function(event) {
            @this.set('editor', event.editor.getData());
        })
    </script>
@endsection

