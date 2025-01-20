@props([
    'title' => 'Title',
    'background' => 'fe/img/carousel-1.jpg',
    'breadcrumbs' => [],
])

<div class="container-fluid bg-primary py-5 mb-5"
    style="background: linear-gradient(rgba(24, 29, 56, .7), rgba(24, 29, 56, .7)), url({{ asset($background) }}); background-size: cover; background-position: center;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">{{ $title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="{{ route('index') }}">Beranda</a></li>
                        @foreach ($breadcrumbs as $breadcrumb)
                            @if ($loop->last)
                                <li class="breadcrumb-item text-white active" aria-current="page">
                                    {{ $breadcrumb['title'] }}</li>
                            @else
                                <li class="breadcrumb-item text-white"><a class="text-white"
                                        href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
