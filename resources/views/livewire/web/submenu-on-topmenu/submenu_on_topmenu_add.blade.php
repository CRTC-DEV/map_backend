<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h1">Add Device Touch GroupFunction</h1>
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
        <form wire:submit.prevent="save">
            {{-- Data info --}}
            <div class="card card-body border-0 shadow mb-4">
                <div class="row">
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>GroupFunction Fields</legend>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="SubmenuOnTopmenu.GroupFunctionId">Available Top Menu</label>
                                <select name="SubmenuOnTopmenu.GroupFunctionId" wire:model="SubmenuOnTopmenu.TopMenuId"
                                    class="form-control mb-0 flex-grow-1" id="TitleId"
                                    aria-label="Title select example" style="min-width: 200px;"
                                    >
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($available_topmenu as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->title->textcontent->OriginalText ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('SubmenuOnTopmenu.TopMenuId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <!-- DeviceTouchScreen Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="selectedDevices">Available SubMenu</label>
                                <select name="selectedDevices" wire:model="SubmenuOnTopmenu.SubMenuId"
                                    class="form-control mb-0 flex-grow-1" id="available_SubMenu"
                                    aria-label="Title select example" style="min-width: 200px;"
                                    >
                                    <option value="{{ null }}">Please select</option>
                                    @foreach ($available_submenu as $item)
                                        <option value="{{ $item->Id }}">{{ $item->Id }} -
                                            {{ $item->title->textcontent->OriginalText ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('SubmenuOnTopmenu.SubMenuId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <!-- SubmenuOnTopmenu Fields -->
                    <fieldset class="col-md-12 mb-4 border p-3">
                        <legend>SubmenuOnTopmenu Fields</legend>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="linkStatus">SubmenuOnTopmenu Status</label>
                                <select wire:model="SubmenuOnTopmenu.Status" class="form-control" id="linkStatus">
                                    <option value="">Select Link Status</option>
                                    <option value="2">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                @error('SubmenuOnTopmenu.Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="col-md-3 mb-3">
                                <label for="orderIndex">Order Index</label>
                                <input wire:model.defer="SubmenuOnTopmenu.OrderIndex" type="number"
                                    class="form-control" id="orderIndex" placeholder="Enter Order Index">
                                @error('SubmenuOnTopmenu.OrderIndex')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('admin.submenuontopmenu') }}" class="btn btn-secondary btn-icon-split">
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
@endsection
