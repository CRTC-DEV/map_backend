<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">GroupFunction DeviceTouch List</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-start align-items-center">
            <a href="{{ route('admin.submenuontopmenu.add') }}" class="btn btn-primary btn-icon-split ml-3">
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
                            <th>Top Menu Title</th>
                            <th>Sub Menu Title</th>
                            <th>Status</th>
                            <th>Order Index</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($submenu_on_topmenu as $item)
                            <tr>
                                <td>{{ $item->topmenu->title->textcontent->OriginalText ?? ''}}</td>
                                <td>{{ $item->submenu->title->textcontent->OriginalText ?? ''}}</td>
                                <td>{{ ($item->Status == ENABLE ? 'Enable' : 'Disable') ?? '' }}</td>
                                <td>{{ $item->OrderIndex ?? ''}}</td>
                                <td>{{ $item->CreatedDate ?? ''}}</td>
                                <td>{{ $item->ModifiDate  ?? ''}}</td>
                                <td>
                                    <a class="btn btn-info btn-circle btn-sm"
                                        href="submenuontopmenu-edit/{{ $item->TopMenuId . ',' . $item->SubMenuId }}">
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
