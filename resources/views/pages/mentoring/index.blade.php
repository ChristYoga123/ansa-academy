@extends('layouts.app')
@push('styles')
    <style>
        .pagination {
            justify-content: center;
            gap: 5px;
        }

        .pagination .page-item .page-link {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            color: var(--primary);
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .pagination .page-item .page-link:hover {
            background-color: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>
@endpush
@section('content')
    <!-- Header Start -->
    @HeaderBreadcumbs([
        'title' => 'Mentoring',
        'breadcrumbs' => [['title' => 'Mentoring', 'url' => '']],
    ])
    <!-- Header End -->


    <!-- Categories Start -->
    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Kategori</h6>
                <h1 class="mb-5">Kategori Mentoring</h1>
            </div>
            <div class="row g-3">
                <div class="col-lg-7 col-md-6">
                    <div class="row g-3">
                        <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="{{ asset('fe/img/cat-1.jpg') }}" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                    style="margin: 1px;">
                                    <h5 class="m-0">Web Design</h5>
                                    <small class="text-primary">49 Courses</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="{{ asset('fe/img/cat-2.jpg') }}" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                    style="margin: 1px;">
                                    <h5 class="m-0">Graphic Design</h5>
                                    <small class="text-primary">49 Courses</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="{{ asset('fe/img/cat-3.jpg') }}" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                    style="margin: 1px;">
                                    <h5 class="m-0">Video Editing</h5>
                                    <small class="text-primary">49 Courses</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                    <a class="position-relative d-block h-100 overflow-hidden" href="">
                        <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('fe/img/cat-4.jpg') }}"
                            alt="" style="object-fit: cover;">
                        <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin:  1px;">
                            <h5 class="m-0">Online Marketing</h5>
                            <small class="text-primary">49 Courses</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Categories Start -->

    <!-- Courses Start -->
    <div class="container-xxl py-5" id="popular-mentoring">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Mentoring</h6>
                <h1 class="mb-5">Daftar Mentoring</h1>
            </div>

            <!-- Add this tab section -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center gap-3 mentoring-tabs">
                        <button class="btn btn-primary active" data-category="all">Semua</button>
                        @foreach ($kategoriMentorings as $kategori)
                            <button class="btn btn-outline-primary"
                                data-category="{{ $kategori->id }}">{{ $kategori->nama }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach ($mentorings as $mentoring)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light">
                            <div class="position-relative overflow-hidden">
                                <img class="img-fluid" src="{{ $mentoring->getFirstMediaUrl('mentoring-thumbnail') }}"
                                    alt="">
                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                    <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end"
                                        style="border-radius: 30px 0 0 30px;">Detail</a>
                                    <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3"
                                        style="border-radius: 0 30px 30px 0;">Daftar</a>
                                </div>
                            </div>
                            <div class="text-center p-4 pb-0">
                                <h3 class="mb-0">{{ ucwords($mentoring->judul) }}</h3>
                                <div class="mb-3">
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small>({{ $mentoring->testimoni_count }})</small>
                                </div>
                                <h6 class="mb-4 text-muted">{{ ucwords($mentoring->kategori->nama) }}</h6>
                            </div>
                            <div class="d-flex border-top">
                                <small class="flex-fill text-center border-end py-2"><i
                                        class="fa fa-user-tie text-primary me-2"></i>{{ $mentoring->mentors_count }}
                                    Mentor</small>
                                <small class="flex-fill text-center border-end py-2"><i
                                        class="fa fa-file text-primary me-2"></i>{{ $mentoring->pakets_count }}
                                    Paket</small>
                                <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30
                                    Murid</small>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- pagination --}}
                <div class="col-lg-12 justify-content-center text-center mt-5 wow fadeInUp" data-wow-delay="0.1s">
                    <nav aria-label="Page navigation">
                        {{ $mentorings->onEachSide(1)->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Courses End -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.mentoring-tabs button');
            const mentoringContainer = document.querySelector('.row.g-4.justify-content-center');
            let currentPage = 1;

            // Handle tab clicks
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Update active state of buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'btn-primary');
                        btn.classList.add('btn-outline-primary');
                    });
                    this.classList.add('active', 'btn-primary');
                    this.classList.remove('btn-outline-primary');

                    // Reset page number and fetch
                    currentPage = 1;
                    fetchMentoring(this.dataset.category);
                });
            });

            // Function to fetch filtered mentoring data
            function fetchMentoring(category) {
                // Show loading state
                mentoringContainer.style.opacity = '0.5';

                const url = new URL(window.location.href);
                url.searchParams.set('category', category);
                url.searchParams.set('page', currentPage);

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.html;

                        // Extract only the mentoring items
                        const newContent = tempDiv.querySelector('.row.g-4.justify-content-center').innerHTML;
                        mentoringContainer.innerHTML = newContent;

                        // Update URL without reload
                        window.history.pushState({}, '', url);

                        // Reset opacity
                        mentoringContainer.style.opacity = '1';

                        // Reinitialize wow.js animations
                        if (typeof WOW !== 'undefined') {
                            new WOW().init();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        mentoringContainer.style.opacity = '1';
                    });
            }

            // Handle pagination clicks
            document.addEventListener('click', function(e) {
                if (e.target.closest('.pagination a')) {
                    e.preventDefault();
                    const url = new URL(e.target.closest('.pagination a').href);
                    currentPage = url.searchParams.get('page') || 1;

                    // Get current active category
                    const activeTab = document.querySelector('.mentoring-tabs button.active');
                    const category = activeTab.dataset.category;

                    fetchMentoring(category);
                }
            });
        });
    </script>

    <style>
        .mentoring-tabs {
            margin-bottom: 2rem;
        }

        .mentoring-tabs button {
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .mentoring-tabs button:hover {
            transform: translateY(-2px);
        }

        .row.g-4.justify-content-center {
            transition: opacity 0.3s ease;
        }
    </style>
@endpush
