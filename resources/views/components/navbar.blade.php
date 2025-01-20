@push('styles')
    <style>
        /* Desktop Styles */
        .dropdown-menu-animated {
            margin-top: 0.5rem;
            padding: 1rem 0;
            border-radius: 8px;
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px) translateZ(0);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, opacity;
        }

        .dropdown:hover .dropdown-menu-animated {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) translateZ(0);
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            position: relative;
            background: transparent;
        }

        .dropdown-item:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
            padding-left: 1.75rem;
        }

        .dropdown-item.active {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
            color: var(--bs-primary);
            font-weight: 500;
        }

        .menu-bullet {
            display: inline-flex;
            width: 8px;
            height: 8px;
            align-items: center;
            justify-content: center;
        }

        .bullet-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background-color: #b5b5c3;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover .bullet-dot {
            background-color: var(--bs-primary);
            width: 6px;
            height: 6px;
        }

        /* Mobile Styles */
        @media (max-width: 991.98px) {
            .dropdown-menu-animated {
                display: block;
                margin: 0;
                padding: 0;
                max-height: 0;
                overflow: hidden;
                opacity: 1;
                visibility: visible;
                transform: none;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                background-color: rgba(var(--bs-primary-rgb), 0.05);
                border-radius: 0;
                box-shadow: none !important;
            }

            .submenu-wrapper {
                padding: 0.5rem 0;
                opacity: 0;
                transform: translateX(-10px) translateZ(0);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                will-change: transform, opacity;
            }

            .dropdown.show .dropdown-menu-animated {
                max-height: 500px;
            }

            .dropdown.show .submenu-wrapper {
                opacity: 1;
                transform: translateX(0) translateZ(0);
            }

            .dropdown-toggle::after {
                transition: transform 0.3s ease;
            }

            .dropdown.show .dropdown-toggle::after {
                transform: rotate(180deg);
            }

            .dropdown-item {
                padding: 0.75rem 2rem;
                transform: translateX(-10px) translateZ(0);
                opacity: 0;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                transition-delay: calc(var(--item-index) * 0.1s);
                will-change: transform, opacity;
            }

            .dropdown.show .dropdown-item {
                transform: translateX(0) translateZ(0);
                opacity: 1;
            }

            .dropdown-item:active,
            .dropdown-item:hover {
                background-color: rgba(var(--bs-primary-rgb), 0.1);
                padding-left: 2.5rem;
            }

            .navbar-nav {
                max-height: calc(100vh - 70px);
                overflow-y: auto;
            }
        }

        /* Navbar brand adjustments */
        .navbar-brand {
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            opacity: 0.85;
        }

        /* Button styling */
        .btn-primary {
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-primary .fa {
            transition: transform 0.3s ease;
        }

        .btn-primary:hover .fa {
            transform: translateX(5px);
        }
    </style>
@endpush
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="{{ route('index') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>{{ env('APP_NAME') }}</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            @foreach ($menus as $menu)
                @if (isset($menu['children']))
                    <div class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ request()->is(trim($menu['url'], '/*')) ? 'active' : '' }}"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $menu['menu'] }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated border-0 shadow-lg">
                            <div class="submenu-wrapper">
                                @foreach ($menu['children'] as $child)
                                    <a href="{{ url(trim($child['url'], '*')) }}"
                                        class="dropdown-item d-flex align-items-center {{ request()->is(trim($child['url'], '/')) ? 'active' : '' }}">
                                        <span class="menu-bullet me-2">
                                            <span class="bullet-dot"></span>
                                        </span>
                                        {{ $child['menu'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ url(trim($menu['url'], '*')) }}"
                        class="nav-item nav-link {{ request()->is(trim($menu['url'], '/')) ? 'active' : '' }}">
                        {{ $menu['menu'] }}
                    </a>
                @endif
            @endforeach
        </div>
        {{-- @auth()
            <a href="{{ Auth::user()->hasRole('super_admin') ? route('filament.admin.pages.dashboard') : (Auth::user()->hasRole('mentor') ? route('filament.mentor.pages.dashboard') : route('filament.mentee.pages.dashboard')) }}"
                class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                Hi, {{ Auth::user()->name }}<i class="fa fa-arrow-right ms-3"></i>
            </a>
        @else
            <a href="{{ route('filament.mentee.auth.login') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                Masuk<i class="fa fa-arrow-right ms-3"></i>
            </a>
        @endauth --}}
    </div>
</nav>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set index untuk animasi dropdown items
            const initDropdownAnimations = () => {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.querySelectorAll('.dropdown-item').forEach((item, index) => {
                        item.style.setProperty('--item-index', index);
                    });
                });
            };

            // Handle mobile dropdown animations
            const initMobileDropdowns = () => {
                document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                    toggle.addEventListener('click', function(e) {
                        if (window.innerWidth < 992) {
                            e.preventDefault();
                            const parent = this.closest('.dropdown');
                            const menu = parent.querySelector('.dropdown-menu');

                            // Toggle the dropdown
                            parent.classList.toggle('show');

                            // Adjust aria-expanded
                            this.setAttribute('aria-expanded',
                                this.getAttribute('aria-expanded') === 'true' ? 'false' :
                                'true'
                            );
                        }
                    });
                });
            };

            // Close dropdowns when clicking outside
            const initClickOutside = () => {
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 992) {
                        const dropdowns = document.querySelectorAll('.dropdown.show');
                        dropdowns.forEach(dropdown => {
                            if (!dropdown.contains(e.target)) {
                                dropdown.classList.remove('show');
                                dropdown.querySelector('.dropdown-toggle')
                                    .setAttribute('aria-expanded', 'false');
                            }
                        });
                    }
                });
            };

            // Initialize all handlers
            initDropdownAnimations();
            initMobileDropdowns();
            initClickOutside();
        });
    </script>
@endpush
