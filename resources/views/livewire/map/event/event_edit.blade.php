<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Edit Event</h1>
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
                    <!-- Event Fields -->
                   <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>Event Fields</legend>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="TitleId">Title ID</label>
                                <select name="Event.TitleId" wire:model="Event.TitleId"
                                    class="form-control mb-0 flex-grow-1 select2" id="TitleId"
                                    aria-label="Title select example" style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($item_title as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->OriginalText }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('Event.TitleId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="DescriptionId">Description ID</label>
                                <select name="Event.TitleId" wire:model="Event.DescriptionId"
                                    class="form-control mb-0 flex-grow-1 select2" id="DescriptionId"
                                    aria-label="DescriptionId select" style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($item_description as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->OriginalText }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('Event.DescriptionId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="T2LocationId">T2location ID</label>
                                <select name="Event.T2LocationId" wire:model="Event.T2LocationId"
                                    class="form-control mb-0 flex-grow-1 select2" id="T2LocationId"
                                    aria-label="T2LocationId select example" style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($t2_location as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} - {{ $item->Name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('Event.T2LocationId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="longitudes">Longitudes</label>
                                <input wire:model="Event.Longitudes" class="form-control" id="longitudes"
                                    placeholder="Enter Longitudes">
                                @error('Event.longitudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="latitudes">Latitudes</label>
                                <input wire:model="Event.Latitudes" class="form-control" id="latitudes"
                                    placeholder="Enter Latitudes">
                                @error('Event.latitudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ImagePathName">Image Path Name</label>
                                <input wire:model="Event.ImagePathName" class="form-control" id="ImagePathName"
                                    placeholder="Enter ImagePathName">
                                @error('Event.ImagePathName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="GroupSearchId">GroupFunction ID</label>
                                <select name="Event.GroupSearchId" wire:model="Event.GroupSearchId"
                                    class="form-control mb-0 flex-grow-1 select2" id="GroupSearchId"
                                    aria-label="GroupSearchId select example" style="min-width: 200px;">
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($group_search as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->Name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('Event.GroupSearchId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="default_point">PeriodFrom</label>
                                <div class="input-group" id="PeriodFrom">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                    <input class="form-control" wire:model.defer="Event.PeriodFrom"
                                        id="startDateInput">
                                </div>
                                @error('Event.PeriodFrom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="default_point">PeriodTo</label>
                                <div class="input-group" id="PeriodTo">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                    <input class="form-control" wire:model.defer="Event.PeriodTo"
                                        id="expiryDateInput">
                                </div>
                                @error('Event.PeriodTo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="IconUrl">Link Url</label>
                                <input wire:model="Event.LinkURL" class="form-control" id="LinkURL"
                                    placeholder="Enter LinkURL">
                                @error('Event.LinkURL')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status">Status</label>
                                <select wire:model="Event.Status" class="form-control" id="status">
                                    <option value="">Select Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('Event.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="EventStatus">EventStatus</label>
                                <select wire:model="Event.EventStatus" class="form-control" id="EventStatus">
                                    <option value="">Select EventStatus</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('Event.EventStatus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('event') }}" class="btn btn-secondary btn-icon-split">
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