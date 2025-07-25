<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Edit ContactNumber</h1>
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
                    <!-- ContactNumber Fields -->
                   <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>ContactNumber Fields</legend>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="TitleId">Contact Number Type ID</label>
                                 <select name="ContactNumber.ContactNumberTypeId" wire:model="ContactNumber.ContactNumberTypeId"
                                    class="form-control mb-0 flex-grow-1 select2" id="TitleId" aria-label="Title select example"
                                    style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($contact_number_type as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->title->textcontent->OriginalText ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ContactNumber.ContactNumberTypeId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="col-md-4 mb-3">
                                <label for="NameId">NameId</label>
                                <input wire:model="ContactNumber.NameId" class="form-control" id="NameId"
                                    placeholder="Enter NameId">
                                @error('ContactNumber.NameId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="col-md-4 mb-3">
                                <label for="TerminalId">TerminalId</label>
                                <input wire:model="ContactNumber.TerminalId" class="form-control" id="TerminalId"
                                    placeholder="Enter TerminalId">
                                @error('ContactNumber.TerminalId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="PhoneNumberId">PhoneNumberId</label>
                                <input wire:model="ContactNumber.PhoneNumberId" class="form-control" id="PhoneNumberId"
                                    placeholder="Enter PhoneNumberId">
                                @error('ContactNumber.PhoneNumberId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status">Status</label>
                                <select wire:model="ContactNumber.Status" class="form-control" id="status">
                                    <option value="">Select Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('ContactNumber.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('contact-number') }}" class="btn btn-secondary btn-icon-split">
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
@endsection
