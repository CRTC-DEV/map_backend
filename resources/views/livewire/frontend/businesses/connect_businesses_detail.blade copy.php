<div class="container mt-4">
    <style>
        .bid-row {
            transition: background-color 0.3s ease;
        }

        .bid-row:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .bid-row:hover .fw-semibold {
            color: #007bff;
        }
    </style>
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-megaphone"></i> THÔNG BÁO MỜI CHÀO GIÁ
        </div>
        <div class="card-body">
            <p class="text-muted">
                <i class="bi bi-clock"></i>
                {{ \Carbon\Carbon::parse($connect_businesses->ModifiDate)->format('d/m/Y H:i:s') }} |
                <i class="bi bi-eye"></i> {{ $connect_businesses->View }} Lượt xem
            </p>
            <h5 class="text-primary fw-bold">{{ $connect_businesses->Title }}</h5>
            <p>{!! $connect_businesses->Description !!}</p>

            @if($connect_businesses->image)
            <div class="mt-3">
                <img src="{{ asset($connect_businesses->Banner) }}" class="img-fluid" alt="Hình ảnh gói thầu">
            </div>
            @endif

            @if($connect_businesses->File)
            <div class="mt-3">
                <iframe src="{{ asset('storage/'.$connect_businesses->File) }}" width="100%" height="500px"></iframe>
            </div>

            <!-- Nút tải về file -->
            <div class="row">

                <div class="md-2 mt-3">
                    <a href="{{ asset('storage/'.$connect_businesses->File) }}" class="btn btn-danger" download>
                        <i class="bi bi-file-earmark-arrow-down"></i> Tải về
                    </a>
                </div>

                <div class="md-3 mt-3 ml-3">
                    <a href="{{ url('/businesses/view') }}" class="btn btn-secondary "><i class="bi bi-arrow-left"></i> Quay lại</a>
                </div>

            </div>
            @endif

        </div>
    </div>

    <!-- Hiển thị bài viết cùng chuyên mục -->
    <div class="card mt-4 shadow">
        <div class="card-header bg-light">
            <i class="bi bi-journal"></i> BÀI VIẾT CÙNG CHUYÊN MỤC
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach( $re_connect_bs as $re_connect)
                <li class="list-group-item bid-row" onclick="window.location='{{ $re_connect['id']}}'">
                    <a href="{{ $re_connect['id']}}" class="text-decoration-none text-primary fw-bold">
                        {{ $re_connect->Title }}
                    </a>
                    <span class="text-muted small">|
                        <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($connect_businesses->ModifiDate)->format('d/m/Y H:i:s') }} |
                        <i class="bi bi-eye"></i> {{ $re_connect->View }} Lượt xem</span>
                </li>
                @endforeach
            </ul>

            <!-- Hiển thị phân trang -->

            <!-- Quan trọng: Kiểm tra nếu biến phân trang tồn tại -->
            @if($re_connect_bs instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-4">
                {{ $re_connect_bs->links() }}
            </div>
            @endif


        </div>
    </div>
</div>