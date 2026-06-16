<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sales Management')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0b1a0e 0%, #1a3a1a 50%, #0d2818 100%);
            min-height: 100vh;
        }
        #sidebar {
            transition: width 0.3s ease, padding 0.3s ease;
            overflow: hidden;
            white-space: nowrap;
            background: rgba(64, 48, 8, 0.95) !important;
            z-index: 1000;
        }
        #sidebar.collapsed {
            width: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        #sidebar.collapsed > * {
            opacity: 0;
            transition: opacity 0.15s ease;
        }
        #sidebarToggle {
            transition: transform 0.2s ease;
        }
        .card {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0,0,0,0.06) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
        }
        .card-body {
            padding: 1.25rem;
        }
        @media (min-width: 992px) {
            main {
                padding: 2rem !important;
            }
            .card-body {
                padding: 1.5rem;
            }
        }
        .table {
            --bs-table-bg: transparent;
        }
        .table tr:last-child td {
            padding-bottom: 0;
        }
        .badge {
            font-weight: 500;
        }
        @media (max-width: 767.98px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 250px !important;
                box-shadow: 0 0 0 9999px transparent;
                transition: width 0.3s ease, padding 0.3s ease, box-shadow 0.3s ease;
            }
            #sidebar.collapsed {
                width: 0 !important;
                transform: translateX(-100%);
                box-shadow: none;
            }
            #sidebar:not(.collapsed) {
                box-shadow: 0 0 0 9999px rgba(0,0,0,0.5);
            }
            main {
                padding: 1rem !important;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex" style="min-height: 100vh;">
        <nav class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" id="sidebar" style="width: 250px;">
            <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none">
                <span class="fs-5 fw-semibold">SalesTracker</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : 'text-white' }}">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/products" class="nav-link {{ request()->is('products*') ? 'active' : 'text-white' }}">
                        <i class="bi bi-box me-2"></i> Products
                    </a>
                </li>
                <li>
                    <a href="/sales" class="nav-link {{ request()->is('sales*') ? 'active' : 'text-white' }}">
                        <i class="bi bi-receipt me-2"></i> Sales
                    </a>
                </li>
                <hr class="my-2">
                <li>
                    <a href="/categories" class="nav-link {{ request()->is('categories*') ? 'active' : 'text-white' }}">
                        <i class="bi bi-tags me-2"></i> Categories
                    </a>
                </li>
                <li>
                    <a href="/brands" class="nav-link {{ request()->is('brands*') ? 'active' : 'text-white' }}">
                        <i class="bi bi-shop me-2"></i> Brands
                    </a>
                </li>
                <li>
                    <a href="/uoms" class="nav-link {{ request()->is('uoms*') ? 'active' : 'text-white' }}">
                        <i class="bi bi-rulers me-2"></i> UOM
                    </a>
                </li>
                <li>
                    <a href="/customers" class="nav-link {{ request()->is('customers*') ? 'active' : 'text-white' }}">
                        <i class="bi bi-people me-2"></i> Customers
                    </a>
                </li>
            </ul>
            <hr>
            <div class="text-center">
                @if(session('user_id'))
                <small class="text-secondary d-block mb-1">
                    <i class="bi bi-person-circle me-1"></i>{{ session('first_name') ?? session('username') }}
                </small>
                <a href="{{ route('profile') }}" class="btn btn-sm btn-outline-light mb-1">
                    <i class="bi bi-gear me-1"></i>Profile
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
                @else
                <a href="/login" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login
                </a>
                @endif
            </div>
            <small class="text-secondary text-center mt-2">SalesTracker v1.0</small>
        </nav>

        <main class="flex-grow-1 p-4" id="mainContent">
            <div class="d-flex mb-3">
                <button id="sidebarToggle" class="btn btn-sm btn-outline-secondary" onclick="toggleSidebar(event)">
                    <i class="bi bi-list fs-5"></i>
                </button>
            </div>
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar(e) {
            if (e) e.stopPropagation();
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth < 768) {
                document.getElementById('sidebar').classList.add('collapsed');
            }

            document.getElementById('mainContent').addEventListener('click', function(e) {
                if (e.target.closest('#sidebarToggle, #sidebar')) return;
                if (window.innerWidth < 768 && !document.getElementById('sidebar').classList.contains('collapsed')) {
                    document.getElementById('sidebar').classList.add('collapsed');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
