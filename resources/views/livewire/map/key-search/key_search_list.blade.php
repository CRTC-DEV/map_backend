<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Group Search List</h1>

    @if (Session::has('message'))
        <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        {{-- <div class="card-header py-3 d-flex justify-content-start align-items-center">
            <a href="{{route('group-search-add')}}" class="btn btn-primary btn-icon-split ml-3">
                <span class="icon text-white-50">
                    <!-- <i class="fas fa-flag"></i> -->
                </span>
                <span class="text">Add Item</span>
            </a>
        </div> --}}

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>                       
                        <th>Id</th>
                        <th>InputSearch</th>
                        <th>DirectLink</th>
                        <th>DeviceCode</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($key_kearch as $item)
                    <tr>
                        <td>{{$item->Id}}</td>
                        <td>{{$item->InputSearch}}</td>
                        <td>{{$item->DirectLink}}</td>
                        <td>{{$item->DeviceCode}}</td>
                        <td>{{$item->CreatedDate}}</td>
                        <td>{{$item->ModifiDate}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('script')
    <script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });
    </script>
@endsection