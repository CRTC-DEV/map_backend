<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Route Map Item Detail List</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Route Map Item Detail List</h6>
            <a href="{{ route('route-map-item-detail-add') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <!-- <i class="fas fa-flag"></i> -->
                </span>
                <span class="text">Add Item</span>
            </a>
        </div>
        @if (Session::has('message'))
            <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <!-- <th>Id</th> -->
                            <th>Route Map Item Id</th>
                            <th>Name Index</th>
                            <th>Status</th>
                            <th>Longitudes</th>
                            <th>Latitudes</th>
                            <th>OrderIndex</th>
                            <th>CreatedDate</th>
                            <th>ModifiDate</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($route_map_item_detail_detail as $item)
                            <tr>
                                <!-- <td>
                            <a href="route-map-item-detail-edit/{{ $item->Id }}" class="m-0 font-weight-bold text-primary">{{ $item->Id }}</a>
                        </td> -->
                                <td>{{ $item->RouteMapItemName }}</td>
                                <td>{{ $item->NameIndex }}</td>
                                <!-- <td>{{ $item->Status }}</td> -->
                                <td>{{ $item->Status == ENABLE ? 'Enable' : 'Disable' }}</td>
                                <td>{{ $item->Longitudes }}</td>
                                <td>{{ $item->Latitudes }}</td>
                                <td>{{ $item->OrderIndex }}</td>
                                <td>{{ $item->CreatedDate }}</td>
                                <td>{{ $item->ModifiDate }}</td>
                                <td>
                                    <a class="btn btn-info btn-circle btn-sm"
                                        href="route-map-item-detail-edit/{{ $item->RouteMapItemId . ',' . $item->Longitudes . ',' . $item->Latitudes }}">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection
