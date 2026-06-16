@extends('layouts.guest')

@section('title', 'SalesTracker')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="/">SalesTracker</a>
        <div>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">
                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
            </a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus me-1"></i> Get Started
            </a>
        </div>
    </div>
</nav>

<header class="bg-dark text-white text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Track Your Sales,<br>Grow Your Business</h1>
        <p class="lead text-secondary mt-3 mb-4">Manage products, record sales, and track performance — all in one place.</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
            <i class="bi bi-rocket-takeoff me-2"></i> Get Started Free
        </a>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-box-seam fs-1 text-primary mb-3 d-block"></i>
                        <h5 class="fw-semibold">Manage Products</h5>
                        <p class="text-muted small mb-0">Add, edit, and organize your products with categories, brands, and pricing.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-receipt fs-1 text-success mb-3 d-block"></i>
                        <h5 class="fw-semibold">Record Sales</h5>
                        <p class="text-muted small mb-0">Log sales transactions, track quantities, and monitor revenue in real time.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-bar-chart-line fs-1 text-warning mb-3 d-block"></i>
                        <h5 class="fw-semibold">View Analytics</h5>
                        <p class="text-muted small mb-0">Get insights with dashboards showing costs, markups, and revenue at a glance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-secondary text-center py-4">
    <small>&copy; {{ date('Y') }} SalesTracker. All rights reserved.</small>
</footer>
@endsection
