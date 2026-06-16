@extends('layouts.app')

@section('title', 'Units of Measure')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-0 text-white">Units of Measure</h2>
        <p class="text-white-50 mb-0">{{ count($uoms) }} uom(s)</p>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <form method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search UOMs..." value="{{ $search ?? '' }}" style="min-width:0">
            @if($search)
                <a href="/uoms" class="btn btn-outline-secondary btn-sm flex-shrink-0">Clear</a>
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
            <i class="bi bi-plus-lg me-1"></i> Add UOM
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

@if(count($uoms) > 0)
<div class="row g-3">
    @foreach($uoms as $u)
    <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h6 class="card-title fw-semibold mb-0">{{ $u->uom_name }}</h6>
                    <span class="badge bg-secondary">#{{ $u->uom_id }}</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm flex-grow-1"
                        onclick="openEditModal(this)"
                        data-id="{{ $u->uom_id }}"
                        data-name="{{ $u->uom_name }}">Edit</button>
                    <button class="btn btn-outline-danger btn-sm flex-grow-1"
                        onclick="openDeleteModal(this)"
                        data-id="{{ $u->uom_id }}"
                        data-name="{{ $u->uom_name }}">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-rulers fs-1 text-white-50"></i>
    <h5 class="text-white mt-2">No units of measure yet</h5>
    <p class="text-white-50">Start by adding a new UOM.</p>
    <button class="btn btn-primary" onclick="openModal()">
        <i class="bi bi-plus-lg me-1"></i> Add UOM
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Add UOM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('uoms.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_modal" value="add">
                <div class="modal-body">
                    <label class="form-label small fw-medium">UOM Name</label>
                    <input type="text" name="uom_name" class="form-control @error('uom_name') is-invalid @enderror" value="{{ old('uom_name') }}">
                    @error('uom_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Edit UOM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="edit">
                <input type="hidden" name="_id" value="{{ old('_id') }}">
                <div class="modal-body">
                    <label class="form-label small fw-medium">UOM Name</label>
                    <input type="text" name="uom_name" class="form-control @error('uom_name') is-invalid @enderror" value="{{ old('uom_name') }}">
                    @error('uom_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                <h5 class="modal-title fw-semibold">Delete UOM</h5>
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
    f.action = '/uoms/' + btn.dataset.id;
    f.querySelector('[name="uom_name"]').value = btn.dataset.name;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
function openDeleteModal(btn) {
    document.getElementById('deleteForm').action = '/uoms/' + btn.dataset.id;
    document.getElementById('deleteName').textContent = btn.dataset.name;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
document.addEventListener('DOMContentLoaded', function() {
    var m = '{{ old("_modal") }}';
    if (m === 'edit') {
        document.getElementById('editForm').action = '/uoms/' + ('{{ old("_id") }}');
        new bootstrap.Modal(document.getElementById('editModal')).show();
    } else if (m === 'add') {
        new bootstrap.Modal(document.getElementById('addModal')).show();
    }
});
</script>
@endpush
@endsection
