<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Item Type List</h1>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-start align-items-left">
            <a href="{{ route('item-type-add') }}" class="btn btn-primary btn-icon-split ml-3">
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
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>IsShow</th>
                            <th>Created at</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item_type as $item)
                            <tr>
                                <td>
                                    <a href="item-type-edit/{{ $item->Id }}"
                                        class="m-0 font-weight-bold text-primary">{{ $item->Id }}</a>
                                </td>
                                <td>{{ $item->Name }}</td>
                                <td>{{ $item->Description }}</td>
                                <td>{{ $item->Status == 1 ? 'Enable' : 'Disable' }}</td>
                                <td>{{ $item->IsShow == 1 ? 'Show' : 'Hidden' }}</td>
                                <td>{{ $item->CreatedDate }}</td>

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
