<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Admin List</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Admin List</h6>
            <a href="{{route('admin.web.add')}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add Admin</span>
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
                            <th width="5%">Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th width="5%">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                @if( $admin->role_id == ROLE_ADMIN) <td>Admin</td> @elseif( $admin->role_id == ROLE_STAFF) <td>Staff</td> @else  <td>Author</td> @endif
                                <td>{{ $admin->created_at }}</td>
                                <td>{{ $admin->updated_at }}</td>
                                <td>
                                    <a class="btn btn-info btn-circle btn-sm" href="{{route('admin.web.edit',[ $admin->id])}}" style="display:{{$admin->id == 1 ? 'none' : ''}}">
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
$(document).ready( function () {
    $('#dataTable').DataTable();
} );
</script>
@endsection
