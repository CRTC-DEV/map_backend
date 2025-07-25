<div class="container mt-4">
    <style>
        .bid-row {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .bid-row:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .bid-row:hover .fw-semibold {
            color: #0056b3;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
            background: linear-gradient(45deg, #1a73e8, #0056b3);
        }

        .header-icon {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .meta-info {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #6c757d;
        }

        .meta-info i {
            color: #0056b3;
        }

        .title-link {
            text-decoration: none;
            color: #2c3e50;
            transition: color 0.3s ease;
        }

        .title-link:hover {
            color: #0056b3;
        }

        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }
    </style>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5><i class="bi bi-megaphone-fill header-icon"></i>
                <span class="fw-bold text-uppercase">
                    {{$originalText}}
            </h5>


            </span>
        </div>

        <div class="card-body p-4">
            @foreach ($bids as $bid)
            <div class="bid-row p-4" onclick="window.location='view/detail/{{ $bid['id'] }}'">
                <div class="meta-info mb-2">
                    <span>
                        <i class="bi bi-clock-fill"></i>
                        {{ \Carbon\Carbon::parse($bid->ModifiDate)->format('d/m/Y H:i:s') }}
                    </span>
                    <span>
                        <i class="bi bi-eye-fill"></i>
                        {{ number_format($bid['View']) }} views
                    </span>
                </div>

                <a href="{{ route('connect.business.detail', ['submenuid' => $submenu_id, 'detailid' => $bid->id]) }}" class="title-link">
                    <h5 class="fw-semibold mb-0">{{ $bid['Title'] }}</h5>
                </a>

            </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        {{ $bids->links() }}
    </div>
</div>