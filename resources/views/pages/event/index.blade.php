@extends('layouts.app')

@push('styles')
    <style>
        .event-card {
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .event-card .thumbnail-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .event-card .thumbnail-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
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

        .event-link {
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }

        .event-link:hover {
            color: inherit;
            text-decoration: none;
        }

        .event-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .timeline-info {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.5rem;
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

        .event-tabs {
            margin-bottom: 2rem;
        }

        .event-tabs button {
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .event-tabs button:hover {
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('content')
    @Header([
        'title' => 'Event',
        'breadcrumbs' => [['title' => 'Event', 'url' => '']],
    ])

    <div class="container-xxl py-5" id="event-section">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Event</h6>
                <h1 class="mb-5">Event Terkini</h1>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mx-auto">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari event..."
                            autocomplete="off" value="{{ request('search') }}">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center gap-3 event-tabs">
                        <button class="btn btn-primary active" data-status="all">
                            Semua ({{ $statusCounts['total'] }})
                        </button>
                        <button class="btn btn-outline-primary" data-status="open">
                            Berjalan ({{ $statusCounts['open'] }})
                        </button>
                        <button class="btn btn-outline-primary" data-status="closed">
                            Selesai ({{ $statusCounts['closed'] }})
                        </button>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-center" id="event-container">
                @forelse ($events as $event)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <a href="{{ route('event.show', $event->slug) }}" class="event-link">
                            <div class="event-card">
                                <div class="thumbnail-container">
                                    <span
                                        class="status-badge {{ Carbon\Carbon::now()->between($event->waktu_open_registrasi, $event->waktu_close_registrasi) ? 'status-open' : 'status-closed' }}">
                                        {{ Carbon\Carbon::now()->between($event->waktu_open_registrasi, $event->waktu_close_registrasi) ? 'Berjalan' : 'Selesai' }}
                                    </span>
                                    <img src="{{ $event->getFirstMediaUrl('event-thumbnail') }}" alt="{{ $event->judul }}">
                                </div>
                                <div class="p-4">
                                    <h4 class="mb-2">{{ $event->judul }}</h4>

                                    <div class="registration-period">
                                        <h6>Periode Pendaftaran</h6>
                                        <div class="date mb-1">
                                            <i class="far fa-calendar-plus text-success"></i>
                                            Mulai:
                                            {{ Carbon\Carbon::parse($event->waktu_open_registrasi)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                        <div class="date mb-1">
                                            <i class="far fa-calendar-minus text-danger"></i>
                                            Tutup:
                                            {{ Carbon\Carbon::parse($event->waktu_close_registrasi)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                        <div class="date mb-1">
                                            <i class="far fa-calendar-check text-primary"></i>
                                            Acara Mulai:
                                            {{ Carbon\Carbon::parse($event->waktu_pelaksanaan)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                        <div class="date mb-1">
                                            <i class="fas fa-users text-warning"></i>
                                            Kuota:
                                            {{ $event->kuota }} Peserta
                                        </div>
                                    </div>

                                    <h5 class="text-primary fw-bold mt-3">
                                        <span class="text-muted">Harga: </span>
                                        Rp {{ number_format($event->harga, 0, ',', '.') }}
                                    </h5>
                                </div>
                                <div class="text-center border-top p-3 mt-auto">
                                    <span class="text-primary fw-bold">Lihat Detail</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h3 class="text-muted">Tidak ada event yang ditemukan</h3>
                    </div>
                @endforelse
            </div>

            <div class="col-12 justify-content-center text-center mt-5 wow fadeInUp" data-wow-delay="0.1s">
                <nav aria-label="Page navigation">
                    {{ $events->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.event-tabs button');
            const eventSection = document.querySelector('#event-section');
            const eventContainer = document.querySelector('#event-container');
            const searchInput = document.getElementById('searchInput');
            let searchTimeout = null;
            let currentPage = 1;

            window.WOW = function() {
                this.init = function() {};
            };

            const initialWow = new WOW({
                boxClass: 'wow',
                offset: 0,
                mobile: true,
                live: false
            });
            initialWow.init();

            const initEventWow = () => {
                const eventItems = eventContainer.querySelectorAll('.wow');
                eventItems.forEach(item => {
                    item.classList.remove('animated');
                    item.style.visibility = '';
                });

                new WOW({
                    boxClass: 'wow',
                    offset: 0,
                    mobile: true,
                    live: false,
                    callback: function(box) {
                        return eventContainer.contains(box);
                    }
                }).init();
            };

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'btn-primary');
                        btn.classList.add('btn-outline-primary');
                    });
                    this.classList.add('active', 'btn-primary');
                    this.classList.remove('btn-outline-primary');

                    currentPage = 1;
                    searchInput.value = '';
                    fetchEvents(this.dataset.status);
                });
            });

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentPage = 1;
                    const activeTab = document.querySelector('.event-tabs button.active');
                    const status = activeTab.dataset.status;
                    fetchEvents(status, this.value);
                }, 500);
            });

            function fetchEvents(status, search = '') {
                eventContainer.style.opacity = '0.5';

                const url = new URL(window.location.href);
                url.searchParams.set('status', status);
                url.searchParams.set('page', currentPage);
                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.html;

                        const newContent = tempDiv.querySelector('.row.g-4.justify-content-center').innerHTML;
                        eventContainer.innerHTML = newContent;

                        const paginationContainer = document.querySelector('nav[aria-label="Page navigation"]');
                        const newPagination = tempDiv.querySelector('nav[aria-label="Page navigation"]');
                        if (paginationContainer && newPagination) {
                            paginationContainer.innerHTML = newPagination.innerHTML;
                        }

                        window.history.pushState({}, '', url);
                        eventContainer.style.opacity = '1';

                        requestAnimationFrame(() => {
                            initEventWow();
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        eventContainer.style.opacity = '1';
                    });
            }

            document.addEventListener('click', function(e) {
                if (e.target.closest('.pagination a')) {
                    e.preventDefault();
                    const url = new URL(e.target.closest('.pagination a').href);
                    currentPage = url.searchParams.get('page') || 1;

                    const activeTab = document.querySelector('.event-tabs button.active');
                    const status = activeTab.dataset.status;

                    fetchEvents(status, searchInput.value);
                }
            });
        });
    </script>
@endpush
