<div class="container mt-4">
    <style>
        .announcement-card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        .announcement-header {
            background: linear-gradient(135deg, #0056b3 0%, #007bff 100%);
            padding: 1rem;
            border-bottom: none;
        }

        .announcement-title {
            color: #2c3e50;
            font-size: 1.5rem;
            font-weight: bold;           
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        
        .meta-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .meta-info i {
            color: #007bff;
            margin-right: 0.5rem;
        }
        
        .document-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .btn-download {
            background: #dc3545;
            border: none;
            padding: 0.7rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-download:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .btn-back {
            background: #6c757d;
            border: none;
            padding: 0.7rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .related-posts {
            margin-top: 2rem;
        }
        
        .related-post-item {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            padding: 1rem;
        }
        
        .related-post-item:hover {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            transform: translateX(5px);
        }
        
        .related-post-link {
            color: #2c3e50;
            text-decoration: none;
        }
        
        .related-post-link:hover {
            color: #007bff;
        }
        
        .post-meta {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>

    <!-- Main Announcement Card -->
    <div class="card announcement-card">
        <div class="card-header announcement-header">
            <h5 class="text-white mb-0">
                <i class="bi bi-megaphone-fill me-2"></i>
                {{$originalText}}
            </h5>
            </div>
        
        <div class="card-body p-4">
            <!-- Meta Information -->
            <div class="meta-info mb-4">
                <span>
                    <i class="bi bi-calendar-event"></i>
                    {{ \Carbon\Carbon::parse($connect_businesses->ModifiDate)->format('d/m/Y H:i:s') }}
                </span>
                <span>
                    <i class="bi bi-eye-fill"></i>
                    {{ number_format($connect_businesses->View) }} Lượt xem
                </span>
                </div>

            <!-- Title and Content -->
            <h2 class="announcement-title">{{ $connect_businesses->Title }}</h2>
            <div class="content-section">
                {!! $connect_businesses->Description !!}
                </div>

            <!-- Image Section -->
            @if($connect_businesses->Banner)
            <div class="mt-4">
                <img src="{{ asset('storage/'.$connect_businesses->Banner) }}" 
                     class="img-fluid rounded shadow" 
                     alt="Hình ảnh gói thầu">
            </div>
            @endif

            <!-- Document Section -->
            @if($connect_businesses->File)
            <div class="document-section mt-4">
                <iframe src="{{ asset('/'.$connect_businesses->Banner) }}" 
                        class="w-100 rounded" 
                        height="500px"></iframe>

                <div class="d-flex gap-3 mt-4">
                    <a href="{{ asset('storage/'.$connect_businesses->File) }}" 
                       class="btn btn-download">
                        <i class="bi bi-file-earmark-arrow-down me-2"></i>
                        Tải về
                    </a>
                    <a href="{{ url('/businesses/view/1') }}" 
                       class="btn btn-back">
                        <i class="bi bi-arrow-left me-2"></i>
                        Quay lại
                    </a>
        </div>
    </div>
            @endif
</div>
    </div>

    <!-- Related Posts Section -->
    <div class="card announcement-card related-posts">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="bi bi-journal-text me-2"></i>
                BÀI VIẾT CÙNG CHUYÊN MỤC
            </h5>
        </div>
        
        <div class="card-body">
            <div class="list-group list-group-flush">
                @foreach($re_connect_bs as $re_connect)
                <div class="related-post-item">
                    <a href="{{ $re_connect['id'] }}" class="related-post-link">
                    <h5>    {{ $re_connect->Title }} </h5>
                    </a>
                    <div class="post-meta mt-2">
                        <i class="bi bi-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($re_connect->ModifiDate)->format('d/m/Y H:i:s') }}
                        <span class="mx-2">•</span>
                        <i class="bi bi-eye me-1"></i>
                        {{ number_format($re_connect->View) }} Lượt xem
                    </div>
                </div>
                @endforeach
            </div>

            @if($re_connect_bs instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-4">
                {{ $re_connect_bs->links() }}
            </div>
            @endif
        </div>
    </div>
</div>