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
                        <label for="Name">Name</label>
                        <input wire:model="group_search.Name" class="form-control" id="Name">
                        @error('group_search.Name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> 
                    <div class="col-md-3 mb-3">
                        <label for="KeySearch">KeySearch</label>
                        <input wire:model="group_search.KeySearch" class="form-control" id="KeySearch">
                        @error('group_search.KeySearch') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> 
                    <div class="col-md-3 mb-3">
                        <label for="group_search.Status">Status </label>
                        <select TextContentId="group_search.Status" wire:model="group_search.Status" class="form-control mb-0" id="Status"
                            aria-label="Gender select example">
                            <option value="{{ null }}">please select</option>
                            <option value="1" >Disable</option>
                            <option value="2" >Enable</option>
                        </select>
                        @error('group_search.Status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="Priority">Priority</label>
                        <input wire:model="group_search.Priority" class="form-control" id="Priority">
                        @error('group_search.Priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> 
                    <div class="col-md-3 mb-3">
                        <label for="Rank">Rank</label>
                        <input wire:model="group_search.Rank" class="form-control" id="Rank">
                        @error('group_search.Rank') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> 
                    <div class="col-md-3 mb-3">
                        <label for="Description">Description</label>
                        <input wire:model="group_search.Description" class="form-control" id="Description">
                        @error('group_search.Description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> 
                    <div class="col-md-3 mb-3">
                        <label for="TitleId">Title</label>
                        <select wire:model="group_search.TitleId" class="form-control" id="TitleId">
                            <option value="">Select a title</option>
                            @foreach($item_title as $item)
                                <option value="{{ $item->Id }}">{{ $item->Id }}-{{ $item->OriginalText }}</option>
                            @endforeach
                        </select>
                        @error('group_search.TitleId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('group-search') }}" class="btn btn-secondary btn-icon-split">
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
@section('script')
<script>
$(document).ready(function() {
     $('#TitleId').select2({
            placeholder: 'Search for a title...',
            allowClear: true,
            minimumResultsForSearch: 0, // Always show search box
        });

        // Ensure Livewire and Select2 work together
        $('#TitleId').on('change', function (e) {
            var data = $('#TitleId').select2("val");
            @this.set('group_search.TitleId', data);
        });
});
</script>
@endsection