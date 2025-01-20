@extends('layouts.app')
@push('styles')
    <style>
        /* Atur tinggi carousel container */
        .header-carousel,
        .header-carousel .owl-item,
        .header-carousel .owl-stage-outer,
        .header-carousel .owl-stage {
            height: 700px;
        }

        /* Atur tinggi item carousel dan gambar */
        .owl-carousel-item {
            height: 700px;
            position: relative;
        }

        .owl-carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Pastikan overlay memenuhi seluruh area */
        .owl-carousel-item .position-absolute {
            height: 700px;
        }

        /* Atur vertical alignment konten */
        .owl-carousel-item .d-flex.align-items-center {
            min-height: 700px;
        }

        /* New styles for course items */
        .course-item {
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .course-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .course-item .thumbnail-container {
            position: relative;
            width: 100%;
            padding-top: 75%;
            /* Changed to 4:3 Aspect Ratio (75% = 3/4) */
            overflow: hidden;
            background-color: #f8f9fa;
            /* Light background for empty state */
        }

        .course-item .thumbnail-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            /* Ensures image is centered */
        }

        .course-item-link {
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }

        .course-item-link:hover {
            color: inherit;
        }

        /* Hide the original detail button since the whole card is clickable */
        .course-item:hover .detail-button {
            opacity: 0;
            pointer-events: none;
        }

        /* Enhanced Mentoring card styles */
        .mentoring-card {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            border-radius: 16px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .mentoring-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .mentoring-card .thumbnail-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio */
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .mentoring-card .thumbnail-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.5s ease;
        }

        .mentoring-card:hover .thumbnail-container img {
            transform: scale(1.05);
        }

        .mentoring-card .category-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            background: rgba(255, 255, 255, 0.95);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(4px);
        }

        .mentoring-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 0.75rem;
        }

        .mentoring-info {
            background: linear-gradient(to right bottom, #f8fafc, #f1f5f9);
            border-radius: 12px;
            padding: 16px;
            margin-top: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .mentoring-info h6 {
            color: #1e293b;
            font-size: 0.85rem;
            margin-bottom: 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .mentoring-info .info-item {
            font-size: 0.85rem;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .mentoring-info .info-item i {
            width: 20px;
            text-align: center;
        }

        .mentoring-info .info-item:last-child {
            margin-bottom: 0;
        }

        .mentoring-link {
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }

        .mentoring-link:hover {
            color: inherit;
            text-decoration: none;
        }

        .mentoring-card .card-content {
            padding: 24px;
        }

        .mentoring-card .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
            line-height: 1.4;
            margin-bottom: 0.75rem;
        }

        .mentoring-card .card-footer {
            text-align: center;
            border-top: 1px solid #e2e8f0;
            padding: 16px;
            margin-top: auto;
            background: linear-gradient(to right, #f8fafc, #ffffff);
        }

        .mentoring-card .detail-link {
            font-weight: 600;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: gap 0.3s ease;
        }

        .mentoring-card:hover .detail-link {
            gap: 10px;
        }

        /* Rating styles */
        .rating-wrapper {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 1rem;
        }

        .rating-stars {
            color: #fbbf24;
            display: flex;
            gap: 2px;
        }

        .review-count {
            font-size: 0.8rem;
            color: #64748b;
            margin-left: 4px;
        }

        /* Stats counter animation */
        @keyframes countUp {
            from {
                transform: translateY(10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .info-item .count {
            animation: countUp 0.5s ease forwards;
        }
    </style>
@endpush
@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('fe/img/carousel-1.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Online Courses</h5>
                                <h1 class="display-3 text-white animated slideInDown">The Best Online Learning Platform</h1>
                                <p class="fs-5 text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed stet
                                    sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea sanctus eirmod
                                    elitr.</p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft"
                                    target="_blank">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($iklans as $iklan)
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="{{ $iklan->getFirstMediaUrl('iklan-thumbnail') }}" alt=""
                        style="width: 100%; height: 800px; object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                        style="background: rgba(24, 29, 56, .7);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-sm-10 col-lg-8">
                                    <h5 class="text-primary text-uppercase mb-3 animated slideInDown">
                                        {{ strtoupper($iklan->tagline) }}
                                    </h5>
                                    <h1 class="display-3 text-white animated slideInDown">{{ $iklan->judul }}
                                    </h1>
                                    <p class="fs-5 text-white mb-4 pb-2">{{ $iklan->subjudul }}</p>
                                    <a href="{{ $iklan->url }}" target="_blank"
                                        class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read
                                        More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Carousel End -->

    {{-- Visi Start --}}
    <section>
        <div class="container py-1 h-100 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="">
                        <div class="p-5">

                            <figure class="text-center mb-0">
                                <blockquote class="blockquote">
                                    <p class="pb-3 text-center">
                                        <i class="fas fa-quote-left fa-xs text-primary"></i>
                                        <span class="lead font-italic" style="font-style: italic">Lorem ipsum dolor sit
                                            amet, consectetur adipisicing
                                            elit. Explicabo, repudiandae.</span>
                                        <i class="fas fa-quote-right fa-xs text-primary"></i>
                                    </p>
                                </blockquote>
                                <figcaption class="blockquote-footer mb-0 text-center">
                                    Visi ANSA
                                </figcaption>
                            </figure>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Visi End --}}

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Mentoring 1 On 1</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                            <h5 class="mb-3">Event</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-chess text-primary mb-4"></i>
                            <h5 class="mb-3">Lomba</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book text-primary mb-4"></i>
                            <h5 class="mb-3">Produk Digital</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('fe/img/about.jpg') }}"
                            alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Tentang Kami</h6>
                    <h1 class="mb-4">Selamat Datang di {{ env('APP_NAME') }}
                    </h1>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et
                        eos. Clita erat ipsum et lorem et sit.</p>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et
                        eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>International Certificate
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>International Certificate
                            </p>
                        </div>
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="">Read More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Courses Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Mentoring</h6>
                <h1 class="mb-5">Mentoring Terbaik Kami</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse ($mentorings as $mentoring)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <a href="#" class="mentoring-link">
                            <div class="mentoring-card">
                                <div class="thumbnail-container">
                                    <img src="{{ $mentoring->getFirstMediaUrl('mentoring-thumbnail') }}"
                                        alt="{{ $mentoring->judul }}">
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title">{{ ucwords($mentoring->judul) }}</h3>

                                    <div class="rating-wrapper">
                                        <div class="rating-stars">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                        <span class="review-count">({{ $mentoring->testimoni_count }} ulasan)</span>
                                    </div>

                                    <div class="mentoring-info">
                                        <h6>Informasi Program</h6>
                                        <div class="info-item">
                                            <i class="fa fa-user-tie"></i>
                                            <span class="count">{{ $mentoring->mentors_count }}</span> Mentor Profesional
                                        </div>
                                        <div class="info-item">
                                            <i class="fa fa-file-alt"></i>
                                            <span class="count">{{ $mentoring->mentoring_pakets_count ?? 0 }}</span>
                                            Paket
                                            Tersedia
                                        </div>
                                        <div class="info-item">
                                            <i class="fa fa-users"></i>
                                            <span class="count">{{ $mentoring->mentoring_mentees_count }}</span> Peserta
                                            Bergabung
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <span class="detail-link">
                                        Lihat Detail
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    {{-- empty state --}}
                    <div class="col-lg-12 text-center">
                        <h5 class="text-muted">Belum ada mentoring</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Courses End -->

    {{-- Video Start --}}
    <section>
        <div class="container py-1 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <iframe width="200" height="600" src="https://www.youtube.com/embed/_ow5Yp9RWhM?si=0KfuIFdki5b4hdP7"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>

            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="">
                        <div class="p-5">
                            <figure class="text-center mb-0">
                                <blockquote class="blockquote">
                                    <p class="pb-3 text-center">
                                        <i class="fas fa-quote-left fa-xs text-primary"></i>
                                        <span class="lead font-italic" style="font-style: italic">Lorem ipsum dolor sit
                                            amet, consectetur adipisicing
                                            elit. Explicabo, repudiandae.</span>
                                        <i class="fas fa-quote-right fa-xs text-primary"></i>
                                    </p>
                                </blockquote>
                                <figcaption class="blockquote-footer mb-0 text-center">
                                    CEO of ANSA Academy
                                </figcaption>
                                <a href="" class="btn btn-primary mt-5">Yuk Daftar</a>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Video End --}}

    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Testimoni</h6>
                <h1 class="mb-5">Testimoni Para Mentee</h1>
            </div>
            {{-- @if (!$testimonies->isEmpty())
                <div class="owl-carousel testimonial-carousel position-relative">
                    @foreach ($testimonies as $testimoni)
                        <div class="testimonial-item text-center">
                            <img class="border rounded-circle p-2 mx-auto mb-3"
                                src="{{ asset($testimoni->user->avatar_url) ?? 'https://ui-avatars.com/api/?name=' . $testimoni->user->name }}"
                                style="width: 80px; height: 80px;">
                            <h5 class="mb-0">{{ $testimoni->user->name }}</h5>
                            <p>{{ $testimoni->user->custom_fields['profesi'] ?? 'Profesi' }}</p>
                            <div class="testimonial-text bg-light text-center p-4">
                                <p class="mb-0" style="font-style: italic;">"{{ $testimoni->komentar }}"</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif($testimonies->count() === 1)
                <div class="text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3"
                        src="{{ asset($testimonies->first()->user->avatar_url) ?? 'https://ui-avatars.com/api/?name=' . $testimonies->first()->user->name }}"
                        style="width: 80px; height: 80px;">
                    <h5 class="mb-0">{{ $testimonies->first()->user->name }}</h5>
                    <p>{{ $testimonies->first()->user->custom_fields['profesi'] ?? 'Profesi' }}</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0" style="font-style: italic;">"{{ $testimonies->first()->komentar }}"</p>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <h5 class="text-muted
                    ">Belum ada testimoni</h5>
                </div>
            @endif --}}
        </div>
    </div>
    <!-- Testimonial End -->

    {{-- FAQ Start --}}
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Tanya ANSA</h6>
                <h1 class="mb-5">FAQ</h1>
            </div>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @forelse ($faqs as $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false"
                                aria-controls="{{ $faq->id }}">
                                {{ $faq->pertanyaan }}
                            </button>
                        </h2>
                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">{!! $faq->jawaban !!}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center">
                        <h5 class="text-muted mt-5">Belum ada FAQ</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    {{-- FAQ END --}}
@endsection
