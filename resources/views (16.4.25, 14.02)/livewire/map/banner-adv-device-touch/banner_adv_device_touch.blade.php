<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Banner Adv && Device Touch Screen</h6>
            <a href="{{ route('banner-adv-device-touch-add') }}" class="btn btn-primary btn-icon-split">
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
                            <th>Banner Adv</th>
                            <th>Device Touch Screen</th>
                            <th>Status</th>
                            <th>CreatedDate</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    {{ $item->banneradv->title->textcontent->OriginalText ?? '' }}
                                </td>
                                <td>
                                    {{ $item->devicetouch->DeviceCode ?? '' }}
                                </td>
                                <td>{{ $item->Status == ENABLE ? 'Enable' : 'Disable' }}</td>
                                <td>{{ $item->CreatedDate }}</td>

                                <td>
                                    <a class="btn btn-info btn-circle btn-sm"
                                        href="banner-adv-device-touch-edit/{{ $item->BanneradvId . ',' . $item->DeviceTouchScreenId }}">
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
