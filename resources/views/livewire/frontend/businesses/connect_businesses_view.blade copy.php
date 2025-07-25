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
        <div class="card-header bg-primary text-white text-uppercase fw-bold">
            <i class="bi bi-megaphone"></i> THÔNG BÁO MỜI CHÀO GIÁ
        </div>
        <div class="card-body p-3">
            @foreach ($bids as $bid)
                <div class="border-bottom py-3 bid-row" onclick="window.location='view/detail/{{ $bid['id'] }}'">
                    <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                            <i class="bi bi-clock"></i> 
                            {{ \Carbon\Carbon::parse($bid->ModifiDate)->format('d/m/Y H:i:s') }} |                           
                            <i class="bi bi-eye"></i> Lượt xem : {{ $bid['View'] }}
                        </span>
                    </div>
                    <div class="mt-1">
                        <a href="view/detail/{{ $bid['id']}}" >
                            <strong class="text-primary"></strong>
                            <span class="fw-semibold">{{ $bid['Title'] }}</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="mt-4">
        {{ $bids->links() }}
    </div>

    
</div>