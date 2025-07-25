<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Device Touch Screen List</h1>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-start align-items-left">
            <a href="{{ route('device-touch-screen-add') }}" class="btn btn-primary btn-icon-split ml-3">
                <span class="icon text-white-50">
                    <!-- <i class="fas fa-flag"></i> -->
                </span>
                <span class="text">Add Item</span>
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>                            <th>Id</th>
                            <th>DeviceCode</th>
                            <th>DeviceSerial</th>
                            <th>T2Location</th>
                            <th>Longitudes</th>
                            <th>Latitudes</th>
                            <th>Airside</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($device_touch_screen as $item)
                            <tr>
                                <td>
                                    <a href="device-touch-screen-edit/{{ $item->Id }}"
                                        class="m-0 font-weight-bold text-primary">{{ $item->Id }}</a>
                                </td>
                                <td>{{ $item->DeviceCode }}</td>
                                <td>{{ $item->DeviceSerial }}</td>
                                <td>{{ $item->T2LocationId }}</td>                                <td>{{ $item->Longitudes }}</td>
                                <td>{{ $item->Latitudes }}</td>
                                <td>{{ $item->Airside == 1 ? 'Yes' : 'No' }}</td>
                                <td>{{ $item->Status == 1 ? 'Enable' : 'Disable' }}</td>

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
$(document).ready( function () {
    $('#dataTable').DataTable();
} );
</script>
@endsection
