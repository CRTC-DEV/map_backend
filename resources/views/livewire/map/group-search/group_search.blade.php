<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Group Search List</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-start align-items-center">       
        <a href="{{route('group-search-add')}}" class="btn btn-primary btn-icon-split ml-3">
            <span class="icon text-white-50">
                <!-- <i class="fas fa-flag"></i> -->
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
                        <th>Name</th>
                        <th>KeySearch</th>
                        <th>Priority</th>
                        <th>Rank</th>
                        <th>Description</th>
                        <th>TitleId</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                                              
                        
                                         
                    </tr>
                </thead>
                <tbody>
                    @foreach($group_search as $item)
                    <tr>
                        <td>
                            <a href="group-search-edit/{{$item->Id}}" class="m-0 font-weight-bold text-primary">{{$item->Id}}</a>
                        </td>
                        <td>{{$item->Name}}</td>
                        <td>{{$item->KeySearch}}</td>
                        <td>{{$item->Priority}}</td>
                        <td>{{$item->Rank}}</td>
                        <td>{{$item->Description}}</td>
                        <td>{{$item->TitleId}}</td>
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
jQuery.noConflict();
jQuery(document).ready(function ($) {
    $('#example').DataTable();
});
</script>
@endsection