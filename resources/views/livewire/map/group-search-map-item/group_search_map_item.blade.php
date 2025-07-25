<div class="container-fluid">
    @if (Session::has('message'))
        <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif

    <h1 class="h3 mb-2 text-gray-800">Group Search Map Item List</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-start align-items-center">
            <a href="{{ route('group-search-map-item-add') }}" class="btn btn-primary btn-icon-split ml-auto">
                <span class="icon text-white-50"><i class="fas fa-arrow-right"></i></span>
                <span class="text">Add Item</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-controls">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <select wire:model="per_page" class="form-control">
                                <option value="5">5 per page</option>
                                <option value="10">10 per page</option>
                                <option value="25">25 per page</option>
                                <option value="100">100 per page</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input wire:model.defer="input_search" type="text" class="form-control" placeholder="Search...">
                        </div>
                        <div class="col-md-3 mb-3">
                            <button wire:click="search" type="button" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50"><i class="fas fa-search"></i></span>
                                <span class="text">Search</span>
                            </button>
                        </div>
                    </div>
                    
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>GroupSearch</th>
                                <th>MapItem</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Show Both Location</th>
                                <th>Search All Floor</th>
                                <th>Created at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = ($group_search_map_item->currentPage() - 1) * $group_search_map_item->perPage() + 1; @endphp
                            @foreach ($group_search_map_item->groupBy('GroupSearchId') as $groupId => $items)
                                @php $rowCount = count($items); @endphp
                                @foreach ($items as $index => $item)
                                    <tr wire:key="group-{{ $groupId }}-item-{{ $index }}">
                                        @if ($index === 0)
                                            <td rowspan="{{ $rowCount }}">{{ $no++ }}</td>
                                            <td rowspan="{{ $rowCount }}">{{ $item->GroupSearchName }} |
                                                {{ $item->GroupSearchKeySearch }}</td>
                                        @endif

                                        <td>
                                            <a href="group-search-map-item-edit/{{ $groupId }},{{ $item['MapItemId'] }}"
                                                class="m-0 font-weight-bold text-primary">
                                                {{ $item['MapItemCadId'] }} - {{ $item['MapItemKeySearch'] }}
                                            </a>
                                        </td>
                                        <td>{{ $item->Priority ?? 'N/A' }}</td>
                                        <td>{{ $item->Status == 1 ? 'Disable' : ($item->Status == 2 ? 'Enable' : 'N/A') }}</td>
                                        <td>{{ $item->IsShowBothLocation ? 'Yes' : 'No' }}</td>
                                        <td>{{ $item->IsSearchAllFloor ? 'Yes' : 'No' }}</td>
                                        <td>{{ $item->CreatedDate ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-end">
                        {{ $group_search_map_item->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script></script>
@endsection
