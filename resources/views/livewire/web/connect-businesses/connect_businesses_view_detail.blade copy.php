<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-megaphone"></i> THÔNG BÁO MỜI CHÀO GIÁ
        </div>
        <div class="card-body">
            <p class="text-muted"><i class="bi bi-clock"></i> {{ $bid->ModifiDate }} | {{ $bid->View }} views</p>
            <h5 class="text-primary fw-bold">TBMCG: {{ $bid->Title }}</h5>
            <p>{{ $bid->description }}</p>

            @if($bid->image)
                <div class="mt-3">
                    <img src="{{ asset('storage/'.$bid->image) }}" class="img-fluid" alt="Hình ảnh gói thầu">
                </div>
            @endif

            @if($bid->pdf_file)
                <div class="mt-3">
                    <iframe src="{{ asset('storage/'.$bid->pdf_file) }}" width="100%" height="500px"></iframe>
                </div>
            @endif

            <a href="{{ url('/') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </div>
    </div>

    <!-- Hiển thị bài viết cùng chuyên mục -->
    <div class="card mt-4 shadow">
        <div class="card-header bg-light">
            <i class="bi bi-journal"></i> BÀI VIẾT CÙNG CHUYÊN MỤC
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($relatedBids as $relatedBid)
                    <li class="list-group-item">
                        <a href="{{ route('bid.detail', $relatedBid->id) }}" class="text-decoration-none text-primary fw-bold">
                            TBMCG: {{ $relatedBid->title }}
                        </a>
                        <span class="text-muted small"> | {{ $relatedBid->date }} | {{ $relatedBid->views }} views</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
