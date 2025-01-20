@extends('layouts.app')
@push('styles')
    <style>
        .success-page {
            padding: 60px 0;
            background: #f8fafc;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .success-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            margin: 0 auto;
        }

        .success-image {
            width: 200px;
            height: 200px;
            margin: 0 auto 2rem;
        }

        .success-title {
            font-size: 2rem;
            color: #10b981;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .success-message {
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .success-card {
                margin: 0 1rem;
                padding: 2rem;
            }

            .success-image {
                width: 150px;
                height: 150px;
            }

            .success-title {
                font-size: 1.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="success-page">
        <div class="container">
            <div class="success-card wow fadeInUp" data-wow-delay="0.1s">
                <div class="success-image">
                    <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Background Circle -->
                        <circle cx="100" cy="100" r="90" fill="#dcfce7" />

                        <!-- Payment Card -->
                        <rect x="40" y="70" width="120" height="75" rx="10" fill="#10b981" />
                        <rect x="50" y="85" width="60" height="8" rx="4" fill="#ffffff" />
                        <rect x="50" y="105" width="40" height="8" rx="4" fill="#ffffff" />
                        <circle cx="140" cy="105" r="15" fill="#dcfce7" />

                        <!-- Check Mark -->
                        <circle cx="100" cy="100" r="30" fill="#059669" />
                        <path d="M85 100L95 110L115 90" stroke="white" stroke-width="6" stroke-linecap="round"
                            stroke-linejoin="round" />

                        <!-- Floating Elements -->
                        <circle cx="50" cy="50" r="8" fill="#10b981" />
                        <circle cx="150" cy="40" r="6" fill="#059669" />
                        <circle cx="160" cy="140" r="10" fill="#10b981" />
                        <circle cx="40" cy="130" r="7" fill="#059669" />
                    </svg>
                </div>

                <h2 class="success-title">Sukses Membayar!</h2>
                <p class="success-message">Terima kasih telah melakukan pembayaran. Selamat belajar!</p>

                <a href="{{ route('filament.app.pages.dashboard') }}" class="btn btn-primary py-3 px-5">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
