<div class="container-fluid">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Add List Sub-Function </h1>
            <button wire:click='opensavelist' class="btn btn-primary btn-icon-split btn-submit">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">Add List Sub-Function</span>
            </button>
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
                    <!-- mainfunction Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>Sub function Fields</legend>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="titleId">Title ID</label>
                                 <select name="mainfunction.TitleId" wire:model="mainfunction.titleId"
                                    class="form-control mb-0 flex-grow-1" id="TitleId" aria-label="Title select example"
                                    style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($item_title as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->OriginalText }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('mainfunction.titleId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="IconUrl">IconUrl</label>
                                <input wire:model="mainfunction.IconUrl" class="form-control" id="IconUrl"
                                    placeholder="Enter IconUrl">
                                @error('mainfunction.IconUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="Link">Link</label>
                                <input wire:model="mainfunction.Link" class="form-control" id="Link"
                                    placeholder="Enter Link">
                                @error('mainfunction.Link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status">Status</label>
                                <select wire:model="mainfunction.Status" class="form-control" id="status">
                                    <option value="">Select Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('mainfunction.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Signages</label>
                                @foreach ($signages as $signage)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="selected_signagesId" 
                                            value="{{ $signage->Id }}" 
                                            id="signage_{{ $signage->Id }}">
                                        <label class="form-check-label" for="signage_{{ $signage->Id }}">
                                            {{ $signage->Id }} - {{ $signage->OriginalText }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('mainfunction') }}" class="btn btn-secondary btn-icon-split">
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
    @include('livewire.popup.mainfunction_modal')
</div>
@section('script')
    <script>
        //Transalation
        document.addEventListener('livewire:load', function() {
            Livewire.on('openListMainFunction', (originalText) => {
                $('#listMainFunctionModal').modal('show'); // Assuming Bootstrap modal
            });
        });
    </script>
@endsection