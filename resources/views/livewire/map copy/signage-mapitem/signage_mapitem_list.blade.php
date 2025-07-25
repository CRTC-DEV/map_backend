<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Signage Mapitem List</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Signage Mapitem List</h6>
            <a href="{{ route('signage-mapitem-add') }}" class="btn btn-primary btn-icon-split">
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
                            <!-- <th>Id</th> -->
                            <th>Signage Title</th>
                            <th>Map Item</th>
                            <th>Status</th>
                            <th>CreatedDate</th>
                            <th>ModifiDate</th>
                            <th class="border-bottom" width="5%">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($signage_mapitem as $item)
                            <tr>
                                {{-- <td>{{ $item->signage->type->Name }}</td> --}}
                                 <td>{{ $item->signage->title->textcontent->OriginalText ?? ''}}</td>
                                <td>{{$item->MapItemId ?? ''}} - {{ $item->mapitem->CadId  ?? ''}}</td>
                                <td>{{ ($item->Status == ENABLE ? 'Enable' : 'Disable') ?? '' }}</td>
                                <td>{{ $item->CreatedDate ?? ''}}</td>
                                <td>{{ $item->ModifiDate ?? ''}}</td>
                                <td>
                                    <a class="btn btn-info btn-circle btn-sm"
                                        href="signage-mapitem-edit/{{ $item->SignageId . ',' . $item->MapItemId }}">
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
