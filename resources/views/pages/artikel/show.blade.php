@extends('layouts.app')

@push('styles')
    <style>
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .article-meta {
            font-size: 0.95rem;
            color: #6c757d;
        }

        .article-featured-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 15px;
            margin: 2rem 0;
        }

        .related-article {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
        }

        .related-article:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .related-article .thumbnail-container {
            position: relative;
            width: 100%;
            padding-top: 60%;
            overflow: hidden;
        }

        .related-article .thumbnail-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-link {
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }

        .article-link:hover {
            color: inherit;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 1rem 0;
        }

        .article-content h2,
        .article-content h3,
        .article-content h4 {
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content blockquote {
            border-left: 4px solid var(--primary);
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #666;
        }

        .share-buttons {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #dee2e6;
        }

        .share-buttons .btn {
            margin: 0.25rem;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Remove the old related-article styles */
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
    </style>
@endpush

@section('content')
    <!-- Header Start -->
    @Header([
        'title' => ucwords($article->judul),
        'background' => $article->getFirstMediaUrl('artikel-thumbnail'),
        'breadcrumbs' => [['title' => 'Artikel', 'url' => route('blog.index')], ['title' => ucwords($article->judul), 'url' => '']],
    ])
    <!-- Header End -->

    <!-- Article Content Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Article Header -->
                    <div class="text-center mb-4">
                        <h1 class="mb-3">{{ $article->judul }}</h1>
                        <div class="article-meta">
                            <span class="me-3">
                                <i class="far fa-user me-2"></i>Admin
                            </span>
                            <span>
                                <i class="far fa-calendar me-2"></i>{{ $article->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <img src="{{ $article->getFirstMediaUrl('artikel-thumbnail') }}" alt="{{ $article->judul }}"
                        class="article-featured-image wow fadeIn" data-wow-delay="0.1s" loading="lazy">

                    <!-- Article Content -->
                    <div class="article-content wow fadeIn" data-wow-delay="0.2s">
                        {!! $article->konten !!}
                    </div>

                    <!-- Share Buttons -->
                    <div class="share-buttons text-center wow fadeIn" data-wow-delay="0.3s">
                        <h5 class="mb-3">Bagikan Artikel</h5>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                            target="_blank" class="btn btn-primary">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}"
                            target="_blank" class="btn btn-info">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}"
                            target="_blank" class="btn btn-success">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}"
                            target="_blank" class="btn btn-primary">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            @if ($relatedArticles->count() > 0)
                <div class="row mt-5 pt-5 border-top">
                    <div class="col-12">
                        <h3 class="text-center mb-4 wow fadeIn" data-wow-delay="0.1s">Baca Artikel Lainnya</h3>
                    </div>
                    @foreach ($relatedArticles as $relatedArticle)
                        <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="{{ 0.2 + $loop->index * 0.1 }}s">
                            <a href="{{ route('blog.show', $relatedArticle->slug) }}" class="lomba-link">
                                <div class="lomba-card">
                                    <div class="thumbnail-container">
                                        <img src="{{ $relatedArticle->getFirstMediaUrl('artikel-thumbnail') }}"
                                            alt="{{ $relatedArticle->judul }}">
                                    </div>
                                    <div class="p-4">
                                        <h4 class="mb-3">{{ $relatedArticle->judul }}</h4>
                                        <div class="article-meta mb-2">
                                            <i class="far fa-user me-2"></i>Admin |
                                            <i
                                                class="far fa-calendar me-2"></i>{{ $relatedArticle->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                    <div class="text-center border-top p-3 mt-auto">
                                        <span class="text-primary fw-bold">Lihat Detail</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- Article Content End -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize WOW.js
            new WOW({
                boxClass: 'wow',
                offset: 50,
                mobile: true,
                live: false
            }).init();

            // Add target="_blank" to external links in article content
            document.querySelectorAll('.article-content a').forEach(link => {
                if (link.hostname !== window.location.hostname) {
                    link.setAttribute('target', '_blank');
                    link.setAttribute('rel', 'noopener noreferrer');
                }
            });

            // Optional: Add lightbox to images
            document.querySelectorAll('.article-content img').forEach(img => {
                img.style.cursor = 'pointer';
                img.addEventListener('click', function() {
                    // You can implement a lightbox here if needed
                });
            });
        });
    </script>
@endpush
