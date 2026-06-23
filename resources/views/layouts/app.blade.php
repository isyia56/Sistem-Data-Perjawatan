<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed light-style"
    data-assets-path="/assets/"
    data-template="vertical-menu-template-free">

    @livewireStyles

<head>

    <script>
            // Apply theme immediately to prevent flash
            const theme = localStorage.getItem('sneatTheme') || 'light';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark-style');
                document.documentElement.classList.remove('light-style');
            } else {
                document.documentElement.classList.add('light-style');
                document.documentElement.classList.remove('dark-style');
            }

            // Apply color theme immediately to prevent flash
            const colorTheme = localStorage.getItem('themeColor') || 'purple';
            if (colorTheme === 'teal') {
                document.documentElement.classList.add('theme-teal');
            }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/dark-mode.css') }}" />

    @stack('styles')
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <style>
        /* Make brand logo follow the active primary color */
        .app-brand-logo svg path[fill="#7367F0"] {
            fill: var(--bs-primary) !important;
        }

        /* Teal color theme override */
        html.theme-teal {
            --bs-primary: #20c997;
            --bs-primary-rgb: 32, 201, 151;
            --bs-primary-bg-subtle: #d2f4e8;
            --bs-primary-border-subtle: #9de8cd;
            --bs-primary-text-emphasis: #0c6b4f;
        }

        /* Fix pagination arrows */
        nav svg { display: none !important; }

        /* Sneat Pagination Style */
        .pagination { display: flex; gap: 4px; align-items: center; flex-wrap: wrap; margin: 0; }
        .pagination .page-item .page-link {
            border-radius: 6px !important; border: 1px solid #d1d5db;
            color: #566a7f; padding: 6px 12px; font-size: 14px;
            line-height: 1.5; background-color: #fff; transition: all 0.2s;
        }
        .pagination .page-item.active .page-link { background-color: var(--bs-primary) !important; border-color: var(--bs-primary) !important; color: #fff !important; }
        .pagination .page-item.disabled .page-link { color: #adb5bd !important; background-color: #f8f9fa !important; }
        .pagination .page-item .page-link:hover { background-color: rgba(var(--bs-primary-rgb), 0.1) !important; color: var(--bs-primary) !important; border-color: var(--bs-primary) !important; }
        html.dark-style .pagination .page-item .page-link { background-color: #2a2a3d !important; border-color: #3b3b5c !important; color: #a6adc8 !important; }
        html.dark-style .pagination .page-item.active .page-link { background-color: var(--bs-primary) !important; border-color: var(--bs-primary) !important; color: #fff !important; }
        html.dark-style .pagination .page-item.disabled .page-link { background-color: #1e1e2e !important; color: #4b5563 !important; }
        html.dark-style .pagination .page-item .page-link:hover { background-color: rgba(var(--bs-primary-rgb), 0.1) !important; color: var(--bs-primary) !important; }

        /* Fix dropdown option text color untuk light/dark mode */
        select.form-select option {
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            }
        
        /* Fix calendar icon in dark mode */
        .dark-style input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }

       
        /* Fix checkbox label color */
        .form-check-label {
            color: var(--bs-body-color) !important;
        }

        /* Fix modal dark mode */
        html.dark-style .modal-content {
            background-color: #2b2c40 !important;
            color: #e4e6eb !important;
        }
        html.dark-style .modal-header {
            border-color: #444 !important;
        }
        html.dark-style .modal-footer {
            border-color: #444 !important;
        }
        html.dark-style .modal-title {
            color: #e4e6eb !important;
        }

        /* Fix modal close button in dark mode */
        html.dark-style .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* SweetAlert2 dark mode */
        html.dark-style .swal2-popup {
            background-color: #2b2c40 !important;
            color: #e4e6eb !important;
        }
        html.dark-style .swal2-title {
            color: #e4e6eb !important;
        }
        html.dark-style .swal2-html-container {
            color: #a1a5b7 !important;
        }

        /* SweetAlert2 small popup */
        .swal-small { font-size: 0.85rem !important; padding: 1rem !important; border-radius: 12px !important; }
        .swal-small .swal2-title { font-size: 1.1rem !important; font-weight: 700 !important; }
        .swal-small .swal2-icon { width: 3.5rem !important; height: 3.5rem !important; margin: 0.5rem auto !important; border: none !important; background: rgba(231,76,60,0.15) !important; border-radius: 50% !important; }
        .swal-small .swal2-icon .swal2-icon-content { font-size: 1.8rem !important; }
        .btn-swal-delete { border-radius: 8px !important; padding: 10px 30px !important; font-weight: 600 !important; }
        .btn-swal-cancel { border-radius: 8px !important; padding: 10px 30px !important; font-weight: 600 !important; }
    </style>
</head>
<script>
    {{-- Fungsi padam universal - digunakan oleh semua halaman --}}
    function confirmDelete(url, name = 'rekod') {
        Swal.fire({
            title: 'Padam ' + name + '?',
            text: 'Tindakan ini tidak boleh dibatalkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Padam!',
            cancelButtonText: 'Batal',
            customClass: { popup: 'swal-small' },
            width: '320px',
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
        //         function confirmDelete(url, name = 'rekod') {
        //     Swal.fire({
        //         title: 'Delete ' + name + '?',
        //         text: 'Are you sure you would like to do this?',
        //         icon: 'error',
        //         showCancelButton: true,
        //         confirmButtonColor: '#e74c3c',
        //         cancelButtonColor: '#2c2c2c',
        //         confirmButtonText: 'Delete',
        //         cancelButtonText: 'Cancel',
        //       background: 'var(--bs-body-bg)',
        //          color: 'var(--bs-body-color)',
        //         iconColor: '#e74c3c',
        //         customClass: {
        //             popup: 'swal-small',
        //             confirmButton: 'btn-swal-delete',
        //             cancelButton: 'btn-swal-cancel',
        //         },
        //         width: '380px',
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             const form = document.createElement('form');
        //             form.method = 'POST';
        //             form.action = url;
        //             form.innerHTML = `
        //                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
        //                 <input type="hidden" name="_method" value="DELETE">
        //             `;
        //             document.body.appendChild(form);
        //             form.submit();
        //         }
        //     });
        // }
    }
</script>


@livewireScripts
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <!-- Sidebar -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <!-- <a href="{{ route('dashboard') }}" class="app-brand-link">
                    <img src="{{ asset('assets/img/logo2.png') }}" alt="Logo"
                        style="width: 30px; height: 30px; object-fit: contain;">
                    <span class="app-brand-text demo menu-text fw-bold ms-2">
                        {{ config('app.name') }}
                    </span>
                </a> -->
                <span class="app-brand-logo demo">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0"/>
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616"/>
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0"/>
                    </svg>
                </span>
                <span class="app-brand-text demo menu-text fw-bold ms-2">
                    {{ config('app.name') }}
                </span>
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                    <i class="bx bx-chevron-left align-middle"></i>
                </a>
            </div>

            <div class="menu-divider mt-0"></div>
            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">

                <!-- Dashboard -->
                <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-smile"></i>
                        <div class="text-truncate">Dashboard</div>
                    </a>
                </li>

                <!-- Buku Waran -->
                <li class="menu-item {{ request()->routeIs('waran*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-book-open"></i>
                        <div class="text-truncate">Buku Waran</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('waran*') ? 'active' : '' }}">
                            <a href="{{ route('waran.index') }}" class="menu-link">
                                <div class="text-truncate">Waran</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Pengurusan -->
                <li class="menu-item {{ request()->routeIs('pegawai*') || request()->routeIs('pegawai-kontrak*') || request()->routeIs('letak-jawatan*')||request()->routeIs('pencen*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-briefcase"></i>
                        <div class="text-truncate">Pengurusan</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('pegawai*') && !request()->routeIs('pegawai-kontrak*') ? 'active' : '' }}">
                            <a href="{{ route('pegawai.index') }}" class="menu-link">
                                <div class="text-truncate">Pegawai</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('letak-jawatan*') ? 'active' : '' }}">
                            <a href="{{ route('letak-jawatan.index') }}" class="menu-link">
                                <div class="text-truncate">Letak Jawatan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('pencen*') ? 'active' : '' }}">
                            <a href="{{ route('pencen.index') }}" class="menu-link">
                                <div class="text-truncate">Penamatan Perkhidmatan</div>
                            </a>
                        </li>
                    </ul>
</li>

                <!-- Kawalan -->
                <li class="menu-item {{ request()->routeIs('program*') || request()->routeIs('ptj*') || request()->routeIs('bahagian*') || request()->routeIs('unit*') || request()->routeIs('subunit*') || request()->routeIs('gred*') || request()->routeIs('jawatan*') || request()->routeIs('opsyen-pencen*') || request()->routeIs('parlimen*')  ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-server"></i>
                        <div class="text-truncate">Kawalan</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('program*') ? 'active' : '' }}">
                            <a href="{{ route('program.index') }}" class="menu-link">
                                <div class="text-truncate">Program & Aktiviti</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('ptj*') ? 'active' : '' }}">
                            <a href="{{ route('ptj.index') }}" class="menu-link">
                                <div class="text-truncate">PTJ</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('bahagian*') ? 'active' : '' }}">
                            <a href="{{ route('bahagian.index') }}" class="menu-link">
                                <div class="text-truncate">Bahagian</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('unit*') ? 'active' : '' }}">
                            <a href="{{ route('unit.index') }}" class="menu-link">
                                <div class="text-truncate">Unit</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('subunit*') ? 'active' : '' }}">
                            <a href="{{ route('subunit.index') }}" class="menu-link">
                                <div class="text-truncate">Subunit</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="/app/kumpulans" class="menu-link">
                                <div class="text-truncate">Kumpulan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('gred*') ? 'active' : '' }}">
                            <a href="{{ route('gred.index') }}" class="menu-link">
                                <div class="text-truncate">Gred</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('jawatan*') ? 'active' : '' }}">
                            <a href="{{ route('jawatan-gred.index') }}" class="menu-link">
                                <div class="text-truncate">Jawatan & Gred</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('opsyen-pencen*') ? 'active' : '' }}">
                            <a href="{{ route('opsyen-pencen.index') }}" class="menu-link">
                                <div class="text-truncate">Opsyen Pencen</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('parlimen*') ? 'active' : '' }}">
                            <a href="{{ route('parlimen.index') }}" class="menu-link">
                                <div class="text-truncate">Parlimen</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="/app/jenis-pencens" class="menu-link">
                                <div class="text-truncate">Jenis Penamatan Perkhidmatan</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Sistem -->
                <li class="menu-item {{ request()->routeIs('pengguna*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-cog"></i>
                        <div class="text-truncate">Sistem</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('pengguna*') ? 'active' : '' }}">
                            <a href="{{ route('pengguna.index') }}" class="menu-link">
                                <div class="text-truncate">Pengguna</div>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Rujukan -->
                <li class="menu-item {{ request()->routeIs('aktiviti*') || request()->routeIs('butiran*') || request()->routeIs('dun*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-book"></i>
                        <div class="text-truncate">Rujukan</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('aktiviti*') ? 'active' : '' }}">
                            <a href="{{ route('aktiviti.index') }}" class="menu-link">
                                <div class="text-truncate">Aktiviti</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('butiran*') ? 'active' : '' }}">
                            <a href="{{ route('butiran.index') }}" class="menu-link">
                                <div class="text-truncate">Butiran</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('dun*') ? 'active' : '' }}">
                            <a href="{{ route('dun.index') }}" class="menu-link">
                                <div class="text-truncate">DUN</div>
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </aside>
        <!-- /Sidebar -->

        <div class="layout-page">
            <!-- Navbar -->
            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme">

                {{-- Mobile only toggle --}}
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                        <i class="bx bx-menu bx-md"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center gap-2 ms-auto justify-content-end w-100">

                    <!-- Dark/Light Mode Toggle -->
                    <div class="nav-item me-2">
                        <a class="nav-link btn btn-text-secondary rounded-pill btn-icon" href="javascript:void(0);" id="themeToggle">
                            <i class="bx bx-moon bx-sm"></i>
                        </a>
                    </div>

                    <!-- Color Theme Toggle (Purple/Teal) -->
                    <div class="nav-item me-2">
                        <a class="nav-link btn btn-text-secondary rounded-pill btn-icon" href="javascript:void(0);" id="colorThemeToggle" title="Tukar warna tema">
                            <i class="bx bx-palette bx-sm"></i>
                        </a>
                    </div>

                    <!-- User dropdown -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <span class="fw-medium d-block">{{ auth()->user()->name }}</span>
                                                <small class="text-muted">{{ auth()->user()->email }}</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li><div class="dropdown-divider"></div></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span>Log Keluar</span>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </nav>
            <!-- /Navbar -->

            <!-- Main Content -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')

                </div>
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>
</div>

<!-- Core JS -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script>
    // Required for Sneat menu.js to enable desktop dropdown
    document.documentElement.classList.add('layout-menu-expanded');
</script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Fix: vendor helpers.js never sets layout-menu-hover to true on mouseenter,
     so the collapsed sidebar never auto-expands on hover. Re-bind it correctly here,
     after main.js, so this listener runs after (and overrides) the broken one. -->
<script>
    (function () {
        const sidebarEl = document.getElementById('layout-menu');
        if (!sidebarEl) return;
        let hoverTimeout;
        sidebarEl.addEventListener('mouseenter', function () {
            if (window.Helpers && window.Helpers.isSmallScreen()) return;
            hoverTimeout = setTimeout(function () {
                document.documentElement.classList.add('layout-menu-hover');
            }, 150);
        });
        sidebarEl.addEventListener('mouseleave', function () {
            clearTimeout(hoverTimeout);
            document.documentElement.classList.remove('layout-menu-hover');
        });
    })();
</script>

<!-- Dark/Light Mode -->
<script>
    const themeToggle = document.getElementById('themeToggle');
    const htmlEl = document.documentElement;
    const icon = themeToggle.querySelector('i');

    const savedTheme = localStorage.getItem('sneatTheme') || 'light';
    if (savedTheme === 'dark') {
        htmlEl.classList.remove('light-style');
        htmlEl.classList.add('dark-style');
        icon.className = 'bx bx-sun bx-sm';
    } else {
        htmlEl.classList.remove('dark-style');
        htmlEl.classList.add('light-style');
        icon.className = 'bx bx-moon bx-sm';
    }

    themeToggle.addEventListener('click', function () {
        const isDark = htmlEl.classList.contains('dark-style');
        if (isDark) {
            htmlEl.classList.remove('dark-style');
            htmlEl.classList.add('light-style');
            localStorage.setItem('sneatTheme', 'light');
            icon.className = 'bx bx-moon bx-sm';
        } else {
            htmlEl.classList.remove('light-style');
            htmlEl.classList.add('dark-style');
            localStorage.setItem('sneatTheme', 'dark');
            icon.className = 'bx bx-sun bx-sm';
        }
    });
</script>

<!-- Purple/Teal Color Theme Toggle -->
<script>
    const colorThemeToggle = document.getElementById('colorThemeToggle');

    function applyColorTheme(color) {
        if (color === 'teal') {
            htmlEl.classList.add('theme-teal');
        } else {
            htmlEl.classList.remove('theme-teal');
        }
    }

    applyColorTheme(localStorage.getItem('themeColor') || 'purple');

    colorThemeToggle.addEventListener('click', function () {
        const isTeal = htmlEl.classList.contains('theme-teal');
        const next = isTeal ? 'purple' : 'teal';
        applyColorTheme(next);
        localStorage.setItem('themeColor', next);
    });
</script>

@stack('scripts')
</body>
</html>
