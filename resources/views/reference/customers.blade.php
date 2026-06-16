@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-0 text-white">Customers</h2>
        <p class="text-white-50 mb-0">{{ count($customers) }} customer(s)</p>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <form method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search customers..." value="{{ $search ?? '' }}" style="min-width:0">
            @if($search)
                <a href="/customers" class="btn btn-outline-secondary btn-sm flex-shrink-0">Clear</a>
            @endif
            <button type="submit" class="btn btn-outline-primary btn-sm flex-shrink-0"><i class="bi bi-search"></i></button>
            <label class="small text-white-50 d-none d-md-inline">Show</label>
            <select name="perPage" class="form-select form-select-sm" style="width:75px;flex-shrink:0" onchange="this.form.submit()">
                <option value="5" {{ ($perPage ?? 10) == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ ($perPage ?? 10) == 20 ? 'selected' : '' }}>20</option>
                <option value="all" {{ ($perPage ?? 10) >= 999999 ? 'selected' : '' }}>All</option>
            </select>
        </form>
        <button class="btn btn-primary flex-shrink-0" onclick="openModal()">
            <i class="bi bi-plus-lg me-1"></i> Add Customer
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(count($customers) > 0)
<div class="row g-3">
    @foreach($customers as $c)
    <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="card-title fw-semibold mb-0">{{ $c->first_name }} {{ $c->last_name }}</h6>
                    <span class="badge bg-secondary">#{{ $c->customer_id }}</span>
                </div>
                <table class="table table-sm table-borderless mb-0 small">
                    <tr><td class="text-muted ps-0">Phone</td><td class="text-end pe-0">{{ $c->phone_number ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">Email</td><td class="text-end pe-0">{{ $c->Gmail ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">Address</td><td class="text-end pe-0">{{ $c->location_address ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">DOB</td><td class="text-end pe-0">{{ $c->bod ?? 'N/A' }}</td></tr>
                </table>
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-outline-primary btn-sm flex-grow-1"
                        onclick="openEditModal(this)"
                        data-id="{{ $c->customer_id }}"
                        data-first_name="{{ $c->first_name }}"
                        data-last_name="{{ $c->last_name }}"
                        data-bod="{{ $c->bod }}"
                        data-phone="{{ $c->phone_number }}"
                        data-email="{{ $c->Gmail }}"
                        data-address="{{ $c->location_address }}">Edit</button>
                    <button class="btn btn-outline-danger btn-sm flex-grow-1"
                        onclick="openDeleteModal(this)"
                        data-id="{{ $c->customer_id }}"
                        data-name="{{ $c->first_name }} {{ $c->last_name }}">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-people fs-1 text-white-50"></i>
    <h5 class="text-white mt-2">No customers yet</h5>
    <p class="text-white-50">Start by adding a new customer.</p>
    <button class="btn btn-primary" onclick="openModal()">
        <i class="bi bi-plus-lg me-1"></i> Add Customer
    </button>
</div>
@endif

@if(isset($lastPage) && $lastPage > 1)
<nav class="mt-4">
    <ul class="pagination pagination-sm justify-content-center mb-0 flex-wrap">
        <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('page'), ['page' => $currentPage - 1])) }}">Previous</a>
        </li>
        @php
            $start = max(1, $currentPage - 2);
            $end = min($lastPage, $currentPage + 2);
            if ($start > 1) {
                echo '<li class="page-item"><a class="page-link" href="' . url()->current() . '?' . http_build_query(array_merge(request()->except('page'), ['page' => 1])) . '">1</a></li>';
                if ($start > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        @endphp
        @for($i = $start; $i <= $end; $i++)
        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
            <a class="page-link" href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('page'), ['page' => $i])) }}">{{ $i }}</a>
        </li>
        @endfor
        @php
            if ($end < $lastPage) {
                if ($end < $lastPage - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                echo '<li class="page-item"><a class="page-link" href="' . url()->current() . '?' . http_build_query(array_merge(request()->except('page'), ['page' => $lastPage])) . '">' . $lastPage . '</a></li>';
            }
        @endphp
        <li class="page-item {{ $currentPage >= $lastPage ? 'disabled' : '' }}">
            <a class="page-link" href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('page'), ['page' => $currentPage + 1])) }}">Next</a>
        </li>
    </ul>
</nav>
@endif

{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_modal" value="add">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">First Name</label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
                            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Last Name</label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
                            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Date of Birth</label>
                            <input type="date" name="bod" class="form-control @error('bod') is-invalid @enderror" value="{{ old('bod') }}">
                            @error('bod') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}">
                            @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Email (Gmail)</label>
                            <input type="email" name="Gmail" class="form-control @error('Gmail') is-invalid @enderror" value="{{ old('Gmail') }}">
                            @error('Gmail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Location / Address</label>
                            <input type="text" name="location_address" class="form-control @error('location_address') is-invalid @enderror" value="{{ old('location_address') }}">
                            @error('location_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="edit">
                <input type="hidden" name="_id" value="{{ old('_id') }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">First Name</label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
                            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Last Name</label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
                            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Date of Birth</label>
                            <input type="date" name="bod" class="form-control @error('bod') is-invalid @enderror" value="{{ old('bod') }}">
                            @error('bod') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}">
                            @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Email (Gmail)</label>
                            <input type="email" name="Gmail" class="form-control @error('Gmail') is-invalid @enderror" value="{{ old('Gmail') }}">
                            @error('Gmail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Location / Address</label>
                            <input type="text" name="location_address" class="form-control @error('location_address') is-invalid @enderror" value="{{ old('location_address') }}">
                            @error('location_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Delete Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <p class="text-muted small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openModal() {
    new bootstrap.Modal(document.getElementById('addModal')).show();
}
function openEditModal(btn) {
    var f = document.getElementById('editForm');
    f.action = '/customers/' + btn.dataset.id;
    f.querySelector('[name="first_name"]').value = btn.dataset.first_name || '';
    f.querySelector('[name="last_name"]').value = btn.dataset.last_name || '';
    f.querySelector('[name="bod"]').value = btn.dataset.bod || '';
    f.querySelector('[name="phone_number"]').value = btn.dataset.phone || '';
    f.querySelector('[name="Gmail"]').value = btn.dataset.email || '';
    f.querySelector('[name="location_address"]').value = btn.dataset.address || '';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
function openDeleteModal(btn) {
    document.getElementById('deleteForm').action = '/customers/' + btn.dataset.id;
    document.getElementById('deleteName').textContent = btn.dataset.name || 'this customer';
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
document.addEventListener('DOMContentLoaded', function() {
    var m = '{{ old("_modal") }}';
    if (m === 'edit') {
        document.getElementById('editForm').action = '/customers/' + ('{{ old("_id") }}');
        new bootstrap.Modal(document.getElementById('editModal')).show();
    } else if (m === 'add') {
        new bootstrap.Modal(document.getElementById('addModal')).show();
    }
});
</script>
@endpush
@endsection
