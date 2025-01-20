@extends('layouts.app')

@push('styles')
    <style>
        /* Card styles */
        .lomba-card {
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .lomba-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .lomba-card .thumbnail-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio */
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .lomba-card .thumbnail-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .competition-content img {
            max-width: 100%;
            height: auto;
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 500;
            color: white;
            z-index: 1;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .status-open {
            background-color: #10B981;
        }

        .status-closed {
            background-color: #EF4444;
        }

        .badge-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
        }

        .badge-status.active {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }

        .badge-status.inactive {
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        .date-badge {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
        }

        .organizer-badge {
            background-color: rgba(102, 16, 242, 0.1);
            color: #6610f2;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
        }

        .lomba-link {
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }

        .lomba-link:hover {
            color: inherit;
            text-decoration: none;
        }

        .lomba-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .registration-period {
            background-color: #F3F4F6;
            border-radius: 8px;
            padding: 12px;
            margin-top: 1rem;
        }

        .registration-period h6 {
            color: #374151;
            font-size: 0.85rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .registration-period .date {
            font-size: 0.8rem;
            color: #6B7280;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-register {
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-register:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2);
        }

        .main-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .related-content {
            max-width: 1000px;
            margin: 0 auto;
        }
    </style>
@endpush

@section('content')
    <!-- Header Start -->
    @Header([
        'title' => ucwords($lomba->judul),
        'background' => $lomba->getFirstMediaUrl('lomba-thumbnail'),
        'breadcrumbs' => [['title' => 'Lomba', 'url' => route('lomba.index')], ['title' => ucwords($lomba->judul), 'url' => '']],
    ])
    <!-- Header End -->

    <!-- Competition Detail Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <!-- Main Content -->
            <div class="main-content">
                <!-- Thumbnail -->
                <div class="mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <img src="{{ $lomba->getFirstMediaUrl('lomba-thumbnail') }}" class="img-fluid rounded w-100"
                        alt="{{ $lomba->judul }}">
                </div>

                <!-- Title & Basic Info -->
                <div class="mb-5 wow fadeInUp" data-wow-delay="0.2s">
                    <h1 class="mb-4 text-center">{{ ucwords($lomba->judul) }}</h1>
                    <div class="d-flex flex-wrap gap-3 justify-content-center mb-4">
                        <span class="organizer-badge">
                            <i class="fa fa-building me-2"></i>
                            {{ $lomba->penyelenggara }}
                        </span>
                        <span class="date-badge">
                            <i class="fa fa-calendar me-2"></i>
                            {{-- set locale to id --}}
                            {{ Carbon\Carbon::parse($lomba->waktu_open_registrasi)->locale('id')->isoFormat('D MMMM YYYY') }}
                            -
                            {{ Carbon\Carbon::parse($lomba->waktu_close_registrasi)->locale('id')->isoFormat('D MMMM YYYY') }}
                        </span>
                        <span
                            class="badge-status {{ Carbon\Carbon::now()->between($lomba->waktu_open_registrasi, $lomba->waktu_close_registrasi) ? 'active' : 'inactive' }}">
                            <i class="fa fa-circle me-2"></i>
                            {{ Carbon\Carbon::now()->between($lomba->waktu_open_registrasi, $lomba->waktu_close_registrasi) ? 'Sedang Berlangsung' : 'Pendaftaran Ditutup' }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="competition-content mb-5">
                        {!! $lomba->deskripsi !!}
                    </div>

                    <!-- Registration Button -->
                    <div class="text-center mb-5">
                        @if (Carbon\Carbon::now()->between($lomba->waktu_open_registrasi, $lomba->waktu_close_registrasi))
                            <a href="{{ $lomba->link_pendaftaran }}" class="btn btn-primary btn-register">
                                <i class="fa fa-paper-plane me-2"></i>
                                Daftar Sekarang
                            </a>
                        @else
                            <button class="btn btn-secondary btn-register" disabled>
                                <i class="fa fa-lock me-2"></i>
                                Pendaftaran Ditutup
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Competitions -->
            <div class="related-content mt-5">
                <h3 class="text-center mb-4">Lomba Lainnya</h3>
                <div class="row g-4 justify-content-center">
                    @forelse ($relatedLombas as $relatedLomba)
                        <div class="col-md-4">
                            <a href="{{ route('lomba.show', $relatedLomba->slug) }}" class="lomba-link">
                                <div class="lomba-card">
                                    <div class="thumbnail-container">
                                        <span
                                            class="status-badge {{ Carbon\Carbon::now()->between($relatedLomba->waktu_open_registrasi, $relatedLomba->waktu_close_registrasi) ? 'status-open' : 'status-closed' }}">
                                            {{ Carbon\Carbon::now()->between($relatedLomba->waktu_open_registrasi, $relatedLomba->waktu_close_registrasi) ? 'Terbuka' : 'Tutup' }}
                                        </span>
                                        <img src="{{ $relatedLomba->getFirstMediaUrl('lomba-thumbnail') }}"
                                            alt="{{ $relatedLomba->judul }}">
                                    </div>
                                    <div class="p-4">
                                        <h4 class="mb-2">{{ $relatedLomba->judul }}</h4>
                                        <div class="lomba-meta">
                                            <i class="far fa-building me-1"></i> {{ $relatedLomba->penyelenggara }}
                                        </div>

                                        <div class="registration-period">
                                            <h6>Periode Pendaftaran</h6>
                                            <div class="date mb-1">
                                                <i class="far fa-calendar-plus text-success"></i>
                                                Mulai:
                                                {{-- set locale to id --}}
                                                {{ Carbon\Carbon::parse($relatedLomba->waktu_open_registrasi)->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm') }}
                                            </div>
                                            <div class="date">
                                                <i class="far fa-calendar-minus text-danger"></i>
                                                Tutup:
                                                {{-- set locale to id --}}
                                                {{ Carbon\Carbon::parse($relatedLomba->waktu_close_registrasi)->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center border-top p-3 mt-auto">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span class="text-primary fw-bold">Lihat Detail</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                            <h3 class="text-muted">Tidak ada lomba yang tersedia.</h3>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- Competition Detail End -->
@endsection
