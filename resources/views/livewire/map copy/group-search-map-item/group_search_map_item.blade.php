<div class="container-fluid">
    @if (Session::has('message'))
        <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    {{-- @dump($group_search_map_item) --}}
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
                    <form wire:submit.prvent="search">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <input wire:model="search" type="text" id="searchInput" class="form-control"
                                    placeholder="Search...">
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="submit" class="btn btn-primary btn-icon-split ml-auto">
                                    <span class="icon text-white-50"><i class="fas fa-search"></i></span>
                                    <span class="text">Search</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>GroupSearch</th>
                                <th>MapItem</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Created at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
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
                                                {{ $item['MapItemId'] }} - {{ $item['MapItemKeySearch'] }}
                                            </a>
                                        </td>
                                        <td>{{ $item->Priority ?? 'N/A' }}</td>
                                        <td>{{ $item->Status ?? 'N/A' }}</td>
                                        <td>{{ $item->CreatedDate ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $group_search_map_item->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script></script>
@endsection
