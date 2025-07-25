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
                        <label for="T2LocationId">T2LocationId</label>
                        <select wire:model.defer="banner_adv.T2LocationId" class="form-control" id="T2LocationId">
                            <option value="">Select a T2LocationId</option>
                            @foreach($t2_location as $item)
                                <option value="{{ $item->Id }}">{{ $item->Id }}-{{ $item->Name }}</option>
                            @endforeach
                        </select>
                        @error('banner_adv.T2LocationId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="TitleId">Title</label>
                        <select wire:model.defer="banner_adv.TitleId" class="form-control" id="TitleId">
                            <option value="">Select a title</option>
                            @foreach($item_title as $item)
                                <option value="{{ $item->Id }}">{{ $item->Id }}-{{ $item->OriginalText }}</option>
                            @endforeach
                        </select>
                        @error('banner_adv.TitleId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                      <div class="col-md-3 mb-3">
                        <label for="DescriptionId">Description</label>
                        <select wire:model.defer="banner_adv.DescriptionId" class="form-control" id="DescriptionId">
                            <option value="">Select a DescriptionId</option>
                            @foreach($description as $item)
                                <option value="{{ $item->Id }}">{{ $item->Id }}-{{ $item->OriginalText }}</option>
                            @endforeach
                        </select>
                        @error('banner_adv.DescriptionId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                   
                     <div class="col-md-3 mb-3">
                        <label for="LinkURL">LinkURL</label>
                        <input wire:model.defer="banner_adv.LinkURL" class="form-control" id="Description">
                        @error('banner_adv.LinkURL') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> 
                   
                    <div class="col-md-3 mb-3">
                        <label for="default_point">StartDate</label>
                        <div class="input-group" id="StartDate">
                            <span class="input-group-addon">
                                 <span class="fa fa-calendar"></span>
                            </span>
                            <input class="form-control" wire:model.defer="banner_adv.StartDate" id="startDateInput">
                        </div>
                        @error('banner_adv.StartDate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="default_point">ExpiryDate</label>
                        <div class="input-group" id="ExpiryDate">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                            <input class="form-control" wire:model.defer="banner_adv.ExpiryDate" id="expiryDateInput">
                        </div>
                        @error('banner_adv.ExpiryDate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="banner_adv.Status">Status </label>
                        <select TextContentId="banner_adv.Status" wire:model.defer="banner_adv.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}" selected>Please select</option>
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('banner_adv.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="mediaType">Media Type</label>
                        <div>
                            <!-- Radio buttons để chọn kiểu media -->
                            <input type="radio" id="imageType" name="mediaType" value="{{ TYPE_IMAGE }}" wire:model="IsVideo">
                            <label for="imageType">Image</label>

                            <input type="radio" id="videoType" name="mediaType" value="{{ TYPE_VIDEO }}" wire:model="IsVideo">
                            <label for="videoType">Video</label>
                        </div>
                    </div>
                    @if($IsVideo == TYPE_IMAGE)
                    <div class="col-md-12 mb-3">
                        <label for="ImagePaths">Upload Images</label>
                        <div class="upload-template" style="width: 100%">
                            @if ($ImagePaths && count($ImagePaths) > 0)
                                @foreach ($ImagePaths as $index => $path)
                                    <div style="display: inline-block; margin-right: 10px; margin-bottom: 10px;">
                                        <!-- Hiển thị ảnh nếu là tệp hoặc ảnh đã tải lên -->
                                        <img width="200px" src="{{ $path instanceof \Livewire\TemporaryUploadedFile ? $path->temporaryUrl() : asset($path) }}" alt="Image">
                                        <button type="button" wire:click="deleteImage({{ $index }})" class="btn btn-danger btn-sm" style="margin-top: 5px;">Xóa</button>
                                    </div>
                                @endforeach
                            @endif
                            <br><input type="file" id="ImagePaths" wire:model="ImagePaths" multiple accept="image/*">
                        </div>
                        @error('ImagePaths.*') 
                            <div class="invalid-feedback">{{ $message }}</div>  
                        @enderror
                        <div id="error-message-ImagePaths" class="invalid-message"></div>
                    </div>
                    @endif
                    @if($IsVideo == TYPE_VIDEO)
                    <div class="col-md-12 mb-12">
                        <label for="LinkURL">Video URL</label>
                        <input wire:model.defer="banner_adv.VideoURL" class="form-control" id="VideoURL">
                        @error('banner_adv.VideoURL') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>
                    @endif
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('banner-adv') }}" class="btn btn-secondary btn-icon-split">
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
    document.addEventListener('livewire:load', function () {
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
@endsection