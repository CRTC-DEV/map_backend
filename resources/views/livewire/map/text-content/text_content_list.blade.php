<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Text Content List</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Text Content List</h6>
            <a href="{{ guarded_route('text-content-add','admin.text-content-add') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
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
                            <th>Id</th>
                            <th>Original Text</th>
                            <th>Original Language</th>
                            <th>Status</th>
                            <th>CreatedDate</th>
                            <th>ModifiDate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($text_content as $item)
                            <tr>
                                <td>
                                    <a href="{{ guarded_url('text-content-edit/'. $item->Id ,
                                        'web-text-content-edit/'. $item->Id ) }}"
                                        class="m-0 font-weight-bold text-primary">{{ $item->Id }}</a>
                                    
                                </td>
                                <td>{{ $item->OriginalText }}</td>
                                <td>{{ $item->LanguageName }}</td>
                                <td>{{ $item->Status == ENABLE ? 'Enable' : 'Disable' }}</td>
                                <td>{{ $item->CreatedDate }}</td>
                                <td>{{ $item->ModifiDate }}</td>

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
