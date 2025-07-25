<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Event List</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-start align-items-center">
            <a href="{{ route('event-add') }}" class="btn btn-primary btn-icon-split ml-3">
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
                            <th>Event Title</th>
                            <th>Event Description</th>
                            <th>Start Day</th>
                            <th>End Day</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event as $item)
                            <tr>
                                <td>{{ $item->title->textcontent->OriginalText ?? ''}}</td>
                                <td>{{ $item->description->textcontent->OriginalText ?? '' }}</td>
                                <td>{{ $item->PeriodFrom }}</td>
                                <td>{{ $item->PeriodTo }}</td>
                                <td>{{ $item->Status == ENABLE ? 'Enable' : 'Disable' }}</td>
                                <td>{{ $item->EventStatus == 2 ? 'Completed' : 'Closed'}}</td>
                                <td>{{ $item->CreatedDate }}</td>
                                <td>{{ $item->ModifiDate }}</td>
                                <td>
                                    <a class="btn btn-info btn-circle btn-sm"
                                        href="event-edit/{{ $item->Id }}">
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
