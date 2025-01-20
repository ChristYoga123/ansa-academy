@extends('layouts.app')

@push('styles')
    <style>
        .event-content img {
            max-width: 100%;
            height: auto;
        }

        .sidebar-wrapper {
            position: sticky;
            top: 100px;
        }

        .timeline-item {
            padding: 1rem;
            border-radius: 8px;
            background: #f8f9fa;
            margin-bottom: 1rem;
        }

        .timeline-date {
            font-size: 0.9rem;
            color: #666;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
@endpush

@section('content')
    @Header([
        'title' => $event->judul,
        'background' => $event->getFirstMediaUrl('event-thumbnail'),
        'breadcrumbs' => [['title' => 'Event', 'url' => route('event.index')], ['title' => $event->judul, 'url' => '']],
    ])

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="mb-5 wow fadeInUp" data-wow-delay="0.1s">
                        <img src="{{ $event->getFirstMediaUrl('event-thumbnail') }}" class="img-fluid rounded"
                            style="width: 100%; max-width: 500px; height: auto;" alt="{{ $event->judul }}">
                    </div>

                    <div class="mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="timeline-item">
                            <h5 class="mb-3">Timeline Event</h5>
                            <div class="timeline-date mb-2">
                                <i class="far fa-calendar-plus text-success"></i>
                                Pembukaan Pendaftaran:
                                {{ Carbon\Carbon::parse($event->waktu_open_registrasi)->format('d M Y, H:i') }}
                            </div>
                            <div class="timeline-date mb-2">
                                <i class="far fa-calendar-minus text-danger"></i>
                                Penutupan Pendaftaran:
                                {{ Carbon\Carbon::parse($event->waktu_close_registrasi)->format('d M Y, H:i') }}
                            </div>
                            <div class="timeline-date mb-2">
                                <i class="far fa-calendar-check text-primary"></i>
                                Acara Mulai: {{ Carbon\Carbon::parse($event->waktu_mulai)->format('d M Y, H:i') }}
                            </div>
                            <div class="timeline-date">
                                <i class="fas fa-users text-warning"></i>
                                Kuota:
                                {{ $event->transaksis_count }}/{{ $event->kuota }} Peserta
                            </div>
                        </div>
                    </div>

                    <div class="mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        <h3 class="mb-4">Deskripsi
                        </h3>
                        <div class="event-content">
                            {!! $event->deskripsi !!}
                        </div>
                    </div>

                    <div class="mb-5 wow fadeInUp" data-wow-delay="0.5s">
                        <h3 class="mb-4">Mentor Berpengalaman</h3>
                        <div class="row g-4 justify-content-start">
                            @forelse ($event->mentors as $mentor)
                                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="team-item bg-light">
                                        <div class="overflow-hidden">
                                            <img class="img-fluid"
                                                src="{{ $mentor->avatar_url ? asset('storage/' . $mentor->avatar_url) : asset('fe/img/team-1.jpg') }}"
                                                alt="{{ $mentor->name }}">
                                        </div>
                                        <div class="position-relative d-flex justify-content-center"
                                            style="margin-top: -23px;">
                                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                                <a class="btn btn-sm-square btn-primary mx-1" href="">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                                <a class="btn btn-sm-square btn-primary mx-1" href="">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                                <a class="btn btn-sm-square btn-primary mx-1" href="">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <h5 class="mb-0">{{ $mentor->name }}</h5>
                                            <small>Mentor</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12 text-center">
                                    <h5 class="text-muted">Belum ada mentor</h5>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar-wrapper">
                        <div class="wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-muted">Status Acara:
                                            {{ $status['is_open'] ? 'Berjalan' : 'Selesai' }}</h6>
                                        <span
                                            class="badge bg-{{ $status['is_open'] ? 'success' : 'danger' }} rounded-pill status-badge">
                                            {{ $status['is_open'] && $event->transaksis_count < $event->kuota ? 'Pendaftaran Dibuka' : 'Pendaftaran Ditutup' }}
                                        </span>
                                    </div>
                                    {{-- Kuota --}}
                                    <div class="d-flex gap-1 mb-3">
                                        <h6 class="text-muted my-auto">Kuota:
                                            {{ $event->transaksis_count }}/{{ $event->kuota }} Peserta
                                        </h6>
                                    </div>
                                    <h4 class="mb-3">Rp {{ number_format($event->harga, 0, ',', '.') }}</h4>

                                    @if ($status['is_open'])
                                        @if ($event->transaksi_count < $event->kuota)
                                            <button class="btn btn-primary w-100 mb-3" onclick="beli()" id="btnBeli">
                                                <i class="fas fa-shopping-cart"></i>
                                                Daftar Sekarang
                                            </button>
                                        @else
                                            <div class="alert alert-warning mb-0">
                                                <i class="fas fa-exclamation-triangle me-2"></i>Pendaftaran Ditutup
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Pendaftaran Ditutup
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENTKEY') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar-wrapper');
            const container = document.querySelector('.container-xxl');
            const footer = document.querySelector('footer');

            if (sidebar && container && footer) {
                const updateSidebarPosition = () => {
                    const sidebarHeight = sidebar.offsetHeight;
                    const footerTop = footer.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;

                    if (footerTop < sidebarHeight + 100) {
                        sidebar.style.top = `${footerTop - sidebarHeight - 20}px`;
                    } else {
                        sidebar.style.top = '100px';
                    }
                };

                window.addEventListener('scroll', updateSidebarPosition);
                window.addEventListener('resize', updateSidebarPosition);
                updateSidebarPosition();
            }
        });

        function beli() {
            $.ajax({
                url: `{{ route('event.beli', $event->slug) }}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                beforeSend: function() {
                    // change button
                    processButton();
                },
                success: function(response) {
                    resetButton();
                    if (response.status === 'success') {
                        window.location.href = response.redirect;
                    } else if (response.snap_token) {
                        snap.pay(response.snap_token, {
                            onSuccess: function(result) {
                                window.location.href = `{{ route('pembayaran-sukses') }}`;
                            },
                            onPending: function(result) {
                                window.location.href =
                                    `{{ route('event.show', $event->slug) }}`;
                            },
                            onError: function(result) {
                                toastr.error('Pembayaran gagal. Silakan coba lagi.');
                                resetButton();
                            },
                            onClose: function() {
                                resetButton();
                            }
                        });
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    resetButton();
                    let errorMessage = 'Something went wrong! Please try again.';

                    try {
                        const response = xhr.responseJSON;
                        if (response && response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }

                    toastr.error(errorMessage);
                }
            })
        }
    </script>
@endpush
