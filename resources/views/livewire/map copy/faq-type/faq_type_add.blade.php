<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Add FaqType</h1>
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
                    <!-- FaqType Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>FaqType Fields</legend>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="TitleId">Title ID</label>
                                 <select name="FaqType.TitleId" wire:model="FaqType.TitleId"
                                    class="form-control mb-0 flex-grow-1 select2" id="TitleId" aria-label="Title select example"
                                    style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($item_title as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->OriginalText }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('FaqType.TitleId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="OrderIndex">OrderIndex</label>
                                <input wire:model="FaqType.OrderIndex" class="form-control" id="OrderIndex"
                                    placeholder="Enter OrderIndex">
                                @error('FaqType.OrderIndex')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status">Status</label>
                                <select wire:model="FaqType.Status" class="form-control" id="status">
                                    <option value="">Select Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('FaqType.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('faq-type') }}" class="btn btn-secondary btn-icon-split">
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

@endsection
