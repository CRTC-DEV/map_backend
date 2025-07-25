<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Add Faq</h1>
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
                    <!-- Faq Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>Faq Fields</legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="TitleId">Title ID</label>
                                 <select name="Faq.TitleId" wire:model="Faq.TitleId"
                                    class="form-control mb-0 flex-grow-1 select2" id="TitleId" aria-label="Title select example"
                                    style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($item_title as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->OriginalText }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('Faq.TitleId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="DescriptionId">Description ID</label>
                                 <select name="Faq.TitleId" wire:model="Faq.DescriptionId"
                                    class="form-control mb-0 flex-grow-1 select2" id="DescriptionId" aria-label="DescriptionId select"
                                    style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($item_description as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->OriginalText }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('Faq.DescriptionId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="FAQTypeId">FAQ Type ID</label>
                                 <select name="Faq.FAQTypeId" wire:model="Faq.FAQTypeId"
                                    class="form-control mb-0 flex-grow-1 select2" id="FAQTypeId" aria-label="FAQTypeId select example"
                                    style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($faq_type as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->title->textcontent->OriginalText ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('Faq.FAQTypeId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status">Status</label>
                                <select wire:model="Faq.Status" class="form-control" id="status">
                                    <option value="">Select Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('Faq.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('faq') }}" class="btn btn-secondary btn-icon-split">
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
