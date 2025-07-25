<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Banner Advertisment List</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-start align-items-center">
            <a href="{{ route('banner-adv-add') }}" class="btn btn-primary btn-icon-split ml-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
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
                            <th>T2LocationId</th>
                            <th>TitleId</th>
                            <th>StartDate</th>
                            <th>ExpiryDate</th>
                            <th>Image/VideoUrl</th>
                            <th>LinkURL</th>
                             <th>Status</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banner_adv as $item)
                            <tr>
                                <td>
                                    <a href="banner-adv-edit/{{ $item->Id }}"
                                        class="m-0 font-weight-bold text-primary">{{ $item->Id }}</a>
                                </td>
                                <td>{{ $item->T2locationName }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->StartDate }}</td>
                                <td>{{ $item->ExpiryDate }}</td>
                                @if ($item->IsVideo == TYPE_IMAGE)
                                    <td>
                                        @php
                                            $imagePaths = json_decode($item->ImagePaths, true);
                                        @endphp

                                        @if (!empty($imagePaths) && is_array($imagePaths))
                                            @foreach ($imagePaths as $path)
                                                <img width="100px" src="{{ asset($path) }}" alt=""
                                                    style="margin-right: 5px; margin-bottom: 5px;">
                                            @endforeach
                                        @endif
                                    </td>
                                @elseif($item->IsVideo == TYPE_VIDEO)
                                    <td>{{ $item->VideoURL }}</td>
                                @else
                                    <td><span>Nothing</span></td>
                                @endif
                                <td>{{ $item->LinkURL }}</td>
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
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection
