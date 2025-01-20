@extends('layouts.app')

@push('styles')
    <style>
        .article-search {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }

        .featured-article {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .featured-article:hover {
            transform: translateY(-5px);
        }

        .featured-article .thumbnail-container {
            position: relative;
            width: 100%;
            padding-top: 50%;
            overflow: hidden;
        }

        .featured-article .thumbnail-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .featured-article .content-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.4), transparent);
            color: #ffffff;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .featured-article .content-overlay h2 {
            color: #ffffff;
            font-weight: 600;
        }

        .featured-article .article-meta {
            color: rgba(255, 255, 255, 0.9);
        }

        .featured-article .article-meta i {
            color: rgba(255, 255, 255, 0.8);
        }

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

        .article-meta {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
@endpush

@section('content')
    <!-- Header Start -->
    @Header([
        'title' => 'Artikel',
        'breadcrumbs' => [['title' => 'Artikel', 'url' => '']],
    ])
    <!-- Header End -->

    <!-- Articles Start -->
    <div class="container-xxl py-5" id="articles-section">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Artikel</h6>
                <h1 class="mb-5">Artikel Terbaru</h1>
            </div>

            <!-- Search Bar -->
            <div class="row mb-5">
                <div class="col-md-6 mx-auto">
                    <div class="article-search">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari artikel..."
                                autocomplete="off" value="{{ request('search') }}">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Article -->
            @if ($featuredArticle && empty(request('search')))
                <div class="row mb-5 featured-article-container wow fadeInUp" data-wow-delay="0.1s">
                    <div class="col-12">
                        <a href="{{ route('blog.show', $featuredArticle->slug) }}" class="article-link">
                            <div class="featured-article">
                                <div class="thumbnail-container">
                                    <img src="{{ $featuredArticle->getFirstMediaUrl('artikel-thumbnail') }}"
                                        alt="{{ $featuredArticle->judul }}">
                                </div>
                                <div class="content-overlay">
                                    <h2 class="mb-3">{{ $featuredArticle->judul }}</h2>
                                    <div class="article-meta mb-2">
                                        <i class="far fa-user me-2"></i>Admin |
                                        <i
                                            class="far fa-calendar me-2"></i>{{ $featuredArticle->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Regular Articles -->
            <div class="row g-4 justify-content-center">
                @forelse ($articles as $article)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <a href="{{ route('blog.show', $article->slug) }}" class="lomba-link">
                            <div class="lomba-card">
                                <div class="thumbnail-container">
                                    <img src="{{ $article->getFirstMediaUrl('artikel-thumbnail') }}"
                                        alt="{{ $article->judul }}">
                                </div>
                                <div class="p-4">
                                    <h4 class="mb-3">{{ $article->judul }}</h4>
                                    <div class="article-meta mb-2">
                                        <i class="far fa-user me-2"></i>Admin |
                                        <i class="far fa-calendar me-2"></i>{{ $article->created_at->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="text-center border-top p-3 mt-auto">
                                    <span class="text-primary fw-bold">Lihat Detail</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h3 class="text-muted">Tidak ada artikel yang tersedia.</h3>
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="col-12 justify-content-center text-center mt-5 wow fadeInUp" data-wow-delay="0.1s">
                    <nav aria-label="Page navigation">
                        {{ $articles->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Articles End -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const articlesSection = document.getElementById('articles-section');
            const articlesContainer = articlesSection.querySelector('.row.g-4.justify-content-center');
            const featuredArticleSection = document.querySelector('.featured-article-container');
            let searchTimeout = null;
            let currentPage = 1;

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('search') && featuredArticleSection) {
                featuredArticleSection.style.display = 'none';
            }

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

            const initArticleWow = () => {
                const articleItems = articlesContainer.querySelectorAll('.wow');
                articleItems.forEach(item => {
                    item.classList.remove('animated');
                    item.style.visibility = '';
                });

                new WOW({
                    boxClass: 'wow',
                    offset: 0,
                    mobile: true,
                    live: false,
                    callback: function(box) {
                        return articlesContainer.contains(box);
                    }
                }).init();
            };

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    currentPage = 1;
                    fetchArticles(this.value);
                }, 500);
            });

            function fetchArticles(search = '') {
                articlesContainer.style.opacity = '0.5';

                const url = new URL(window.location.href);
                url.searchParams.set('page', currentPage);

                if (search) {
                    url.searchParams.set('search', search);
                    if (featuredArticleSection) {
                        featuredArticleSection.style.display = 'none';
                    }
                } else {
                    url.searchParams.delete('search');
                    if (featuredArticleSection) {
                        featuredArticleSection.style.display = currentPage == 1 ? 'flex' : 'none';
                    }
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
                        articlesContainer.innerHTML = newContent;
                        articlesContainer.style.opacity = '1';

                        const newFeaturedArticle = tempDiv.querySelector('.featured-article-container');
                        if (featuredArticleSection && newFeaturedArticle) {
                            featuredArticleSection.innerHTML = newFeaturedArticle.innerHTML;
                            featuredArticleSection.style.display = (!search && currentPage == 1) ? 'flex' :
                                'none';
                        }

                        window.history.pushState({}, '', url);

                        requestAnimationFrame(() => {
                            initArticleWow();
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        articlesContainer.style.opacity = '1';
                    });
            }

            document.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('.pagination a');
                if (paginationLink) {
                    e.preventDefault();
                    const url = new URL(paginationLink.href);
                    currentPage = parseInt(url.searchParams.get('page')) || 1;
                    fetchArticles(searchInput.value);
                }
            });

            window.addEventListener('popstate', function() {
                const urlParams = new URLSearchParams(window.location.search);
                currentPage = parseInt(urlParams.get('page')) || 1;
                const searchValue = urlParams.get('search') || '';
                searchInput.value = searchValue;
                fetchArticles(searchValue);
            });
        });
    </script>
@endpush
