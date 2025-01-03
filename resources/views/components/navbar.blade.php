<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>{{ env('APP_NAME') }}</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.html" class="nav-item nav-link {{ Route::is('index') ? 'active' : '' }}">Beranda</a>
            <a href="about.html" class="nav-item nav-link {{ Route::is('mentoring*') ? 'active' : '' }}">Mentoring</a>
            <a href="courses.html" class="nav-item nav-link {{ Route::is('mentor*') ? 'active' : '' }}">Mentor</a>
            <a href="courses.html" class="nav-item nav-link {{ Route::is('lomba*') ? 'active' : '' }}">Info Lomba</a>
            <a href="courses.html" class="nav-item nav-link {{ Route::is('event*') ? 'active' : '' }}">Event
                Unggulan</a>
            <a href="courses.html" class="nav-item nav-link {{ Route::is('artikel*') ? 'active' : '' }}">Artikel</a>
            {{-- <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu fade-down m-0">
                    <a href="team.html" class="dropdown-item">Our Team</a>
                    <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                    <a href="404.html" class="dropdown-item">404 Page</a>
                </div>
            </div> --}}
            {{-- <a href="contact.html" class="nav-item nav-link">Contact</a> --}}
        </div>
        @auth
            <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block text-truncate">Hi,
                {{ Auth::user()->name }}<i class="fa fa-arrow-right ms-3"></i></a>
        @else
            <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i
                    class="fa fa-arrow-right ms-3"></i></a>
        @endauth
    </div>
</nav>
