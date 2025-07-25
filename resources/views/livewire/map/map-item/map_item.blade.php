<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Map Item List</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4" style="vw:100%">
        <div class="card-header py-3 d-flex justify-content-start align-items-left">
            
            <a href="{{route('map-item-add')}}" class="btn btn-primary btn-icon-split">
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
                            <th>Title</th>
                            <th>Cad Id</th>
                            <th>Key Search</th>
                            <th>Status</th>
                            <th>T2 Location</th>
                            <th>Description</th>
                            <th>Store Hours</th>
                            <th>Contact</th>
                            <th>Item Type</th>
                            <th>Rank</th>
                            <th>Area Side</th>
                            <th>Lonqitudes</th>
                            <th>Laqitudes</th>
                            <th>Image</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($map_item as $item)
                        <tr>
                            <td>
                                <a href="map-item-edit/{{$item->Id}}" class="m-0 font-weight-bold text-primary">{{$item->TitleText}}</a>
                            </td>
                            <td>{{$item->CadId}}</td>
                            <td>{{$item->KeySearch}}</td>
                            <td>{{$item->Status == ENABLE ? 'Enable': 'Disable'}}</td>
                            <td>{{$item->LocationName}}</td>
                            <td>{{$item->DescriptionText}}</td>
                            <td>{{$item->StoreHours}}</td>
                            <td>{{$item->Contact}}</td>
                            <td>{{$item->ItemTypeId}}</td>
                            <td>{{$item->Rank}}</td>
                            <td>{{$item->AreaSide==1 ? 'LandSide': 'AirSide'}}</td>
                            <td>{{$item->Longitudes}}</td>
                            <td>{{$item->Latitudes}}</td>
                             <td>
                                @if($item->ImgUrl)
                                    <img src="{{ asset($item->ImgUrl) }}" alt="Map Item Image" style="max-width: 50px; max-height: 50px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{$item->CreatedDate}}</td>
                            
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
    $(document).ready(function () {
        $('#dataTable').DataTable({
            dom: '<"row mb-3"<"col-md-6"l><"col-md-6 text-end"f>>' +
                 '<"row"<"col-md-12"tr>>' +
                 '<"row mt-3"<"col-md-6"i><"col-md-6 text-end"p>>',
            pagingType: "simple_numbers",
            language: {
                lengthMenu: "Hiển thị _MENU_ dòng",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ dòng",
                search: "Tìm kiếm:",
                paginate: {
                    next: "Tiếp",
                    previous: "Trước",
                },
            },
            responsive: true,
        });
    });
</script>

@endsection