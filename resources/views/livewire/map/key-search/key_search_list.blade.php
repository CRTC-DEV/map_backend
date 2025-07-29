<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Key Search List</h1>
        <button wire:click="exportExcel" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Export to Excel
        </button>
    </div>

    @if (Session::has('message'))
        <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Key Search Data</h6>
            <small class="text-muted">Total: {{ count($key_kearch) }} records</small>
        </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>                       
                        <th>ID</th>
                        <th>Input Search</th>
                        <th>Direct Link</th>
                        <th>Device Code</th>
                        <th>Created Date</th>
                        <th>Modified Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($key_kearch as $item)
                    <tr>
                        <td>{{ $item->Id }}</td>
                        <td>{{ $item->InputSearch }}</td>
                        <td>
                            @if($item->DirectLink)
                                <a href="{{ $item->DirectLink }}" target="_blank" class="text-primary">
                                    {{ Str::limit($item->DirectLink, 50) }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $item->DeviceCode ?? '-' }}</td>
                        <td>{{ $item->CreatedDate ? \Carbon\Carbon::parse($item->CreatedDate)->format('Y-m-d H:i:s') : '-' }}</td>
                        <td>{{ $item->ModifiDate ? \Carbon\Carbon::parse($item->ModifiDate)->format('Y-m-d H:i:s') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No key search data found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('script')
    <script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "order": [[ 0, "desc" ]],
            "pageLength": 25,
            "searching": true,
            "lengthChange": true,
            "responsive": true
        });
        
        // Auto-hide alert messages
        setTimeout(function() {
            $('#alert-message').fadeOut();
        }, 3000);
    });
    </script>
@endsection