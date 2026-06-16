@extends('layouts.app')

@section('title', 'Sales')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-0 text-white">Sales</h2>
        <p class="text-white-50 mb-0">{{ count($sales) }} sale(s) recorded</p>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <form method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search sales..." value="{{ $search ?? '' }}" style="min-width:0">
            <select name="status" class="form-select form-select-sm" style="width:auto;flex-shrink:0" onchange="this.form.submit()">
                <option value="">All status</option>
                <option value="completed" {{ ($status ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ ($status ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @if($search || $status)
                <a href="/sales" class="btn btn-outline-secondary btn-sm flex-shrink-0">Clear</a>
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
        <button class="btn btn-primary flex-shrink-0" onclick="openNewSaleModal()">
            <i class="bi bi-plus-lg me-1"></i> New Sale
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

@if(count($sales) > 0)
<div class="row g-3">
    @foreach($sales as $sale)
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="card-title fw-semibold mb-0">Sale #{{ $sale->sale_id }}</h6>
                        <small class="text-muted">{{ $sale->customer_name ?? 'N/A' }}</small>
                    </div>
                    <span class="badge {{ ($sale->status ?? 'completed') === 'completed' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($sale->status ?? 'completed') }}</span>
                </div>
                <table class="table table-sm table-borderless mb-0 small">
                    <tr><td class="text-muted ps-0">Product</td><td class="text-end pe-0">{{ $sale->product_name ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">Category</td><td class="text-end pe-0">{{ $sale->category_name ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">Brand</td><td class="text-end pe-0">{{ $sale->brand_name ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">Quantity</td><td class="text-end pe-0">{{ $sale->quantity ?? 0 }}</td></tr>
                    <tr><td class="text-muted ps-0">UOM</td><td class="text-end pe-0">{{ $sale->uom_name ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">Unit Price</td><td class="text-end pe-0">₱{{ number_format($sale->unit_price ?? 0, 2) }}</td></tr>
                    <tr class="border-top"><td class="fw-semibold ps-0">Total</td><td class="text-end pe-0 fw-bold text-success">₱{{ number_format($sale->total_unitPrice ?? 0, 2) }}</td></tr>
                </table>
                <div class="d-grid gap-2 mt-3" style="grid-template-columns: 1fr 1fr;">
                    <button class="btn btn-outline-success btn-sm"
                        onclick="openViewModal(this)"
                        data-id="{{ $sale->sale_id }}"
                        data-product="{{ $sale->product_name }}"
                        data-customer="{{ $sale->customer_name }}"
                        data-category="{{ $sale->category_name }}"
                        data-brand="{{ $sale->brand_name }}"
                        data-quantity="{{ $sale->quantity }}"
                        data-uom="{{ $sale->uom_name }}"
                        data-unitprice="{{ $sale->unit_price }}"
                        data-total="{{ $sale->total_unitPrice }}">
                        <i class="bi bi-eye"></i> View
                    </button>
                    <button class="btn btn-outline-primary btn-sm"
                        onclick="openEditSaleModal(this)"
                        data-id="{{ $sale->sale_id }}"
                        data-product_id="{{ $sale->product_id }}"
                        data-customer_id="{{ $sale->customer_id }}"
                        data-quantity="{{ $sale->quantity }}">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    @if(($sale->status ?? 'completed') === 'completed')
                    <button class="btn btn-outline-warning btn-sm"
                        onclick="openCancelModal(this)"
                        data-id="{{ $sale->sale_id }}">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    @endif
                    <button class="btn btn-outline-danger btn-sm"
                        onclick="openDeleteModal(this)"
                        data-id="{{ $sale->sale_id }}">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-receipt fs-1 text-white-50"></i>
    <h5 class="text-white mt-2">No sales yet</h5>
    <p class="text-white-50">Record your first sale to get started.</p>
    <button class="btn btn-primary" onclick="openNewSaleModal()">
        <i class="bi bi-plus-lg me-1"></i> New Sale
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

{{-- New Sale Modal --}}
<div class="modal fade" id="newSaleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">New Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sales.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_modal" value="new-sale">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-medium">Product</label>
                            <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                <option value="">Select product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->product_id }}" {{ old('product_id') == $product->product_id ? 'selected' : '' }}>{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                            @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-medium">Customer</label>
                            <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">Select customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-medium">Quantity</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" min="1" required value="{{ old('quantity') }}">
                            @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Record Sale</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Sale Modal --}}
<div class="modal fade" id="editSaleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Edit Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSaleForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="edit-sale">
                <input type="hidden" name="_id" value="{{ old('_id') }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-medium">Product</label>
                            <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                <option value="">Select product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->product_id }}" {{ old('product_id') == $product->product_id ? 'selected' : '' }}>{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                            @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-medium">Customer</label>
                            <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">Select customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-medium">Quantity</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" min="1" required value="{{ old('quantity') }}">
                            @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Sale</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- View Sale Modal --}}
<div class="modal fade" id="viewSaleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Sale Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted ps-0">Sale ID</td><td class="text-end pe-0 fw-semibold" id="viewSaleId"></td></tr>
                    <tr><td class="text-muted ps-0">Product</td><td class="text-end pe-0" id="viewProduct"></td></tr>
                    <tr><td class="text-muted ps-0">Customer</td><td class="text-end pe-0" id="viewCustomer"></td></tr>
                    <tr><td class="text-muted ps-0">Category</td><td class="text-end pe-0" id="viewCategory"></td></tr>
                    <tr><td class="text-muted ps-0">Brand</td><td class="text-end pe-0" id="viewBrand"></td></tr>
                    <tr><td class="text-muted ps-0">Quantity</td><td class="text-end pe-0" id="viewQuantity"></td></tr>
                    <tr><td class="text-muted ps-0">UOM</td><td class="text-end pe-0" id="viewUom"></td></tr>
                    <tr><td class="text-muted ps-0">Unit Price</td><td class="text-end pe-0" id="viewUnitPrice"></td></tr>
                    <tr class="border-top"><td class="fw-semibold ps-0">Total</td><td class="text-end pe-0 fw-bold text-success" id="viewTotal"></td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Cancel Sale Modal --}}
<div class="modal fade" id="cancelSaleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Cancel Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this sale?</p>
                <p class="text-muted small mb-0">The sale will be marked as cancelled.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="cancelSaleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-warning">Cancel Sale</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Delete Sale Confirmation Modal --}}
<div class="modal fade" id="deleteSaleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Delete Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this sale?</p>
                <p class="text-muted small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="deleteSaleForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Sale</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openNewSaleModal() {
    var modal = new bootstrap.Modal(document.getElementById('newSaleModal'));
    modal.show();
}

function openViewModal(btn) {
    document.getElementById('viewSaleId').textContent = '#' + btn.dataset.id;
    document.getElementById('viewProduct').textContent = btn.dataset.product || 'N/A';
    document.getElementById('viewCustomer').textContent = btn.dataset.customer || 'N/A';
    document.getElementById('viewCategory').textContent = btn.dataset.category || 'N/A';
    document.getElementById('viewBrand').textContent = btn.dataset.brand || 'N/A';
    document.getElementById('viewQuantity').textContent = btn.dataset.quantity || '0';
    document.getElementById('viewUom').textContent = btn.dataset.uom || 'N/A';
    document.getElementById('viewUnitPrice').textContent = '₱' + parseFloat(btn.dataset.unitprice || 0).toFixed(2);
    document.getElementById('viewTotal').textContent = '₱' + parseFloat(btn.dataset.total || 0).toFixed(2);
    var modal = new bootstrap.Modal(document.getElementById('viewSaleModal'));
    modal.show();
}

function openEditSaleModal(btn) {
    var form = document.getElementById('editSaleForm');
    form.action = '/sales/' + btn.dataset.id;
    form.querySelector('[name="product_id"]').value = btn.dataset.product_id || '';
    form.querySelector('[name="customer_id"]').value = btn.dataset.customer_id || '';
    form.querySelector('[name="quantity"]').value = btn.dataset.quantity || '';
    var modal = new bootstrap.Modal(document.getElementById('editSaleModal'));
    modal.show();
}

function openCancelModal(btn) {
    document.getElementById('cancelSaleForm').action = '/sales/' + btn.dataset.id + '/cancel';
    var modal = new bootstrap.Modal(document.getElementById('cancelSaleModal'));
    modal.show();
}

function openDeleteModal(btn) {
    document.getElementById('deleteSaleForm').action = '/sales/' + btn.dataset.id;
    var modal = new bootstrap.Modal(document.getElementById('deleteSaleModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    var modalName = '{{ old("_modal") }}';
    if (modalName === 'edit-sale') {
        var form = document.getElementById('editSaleForm');
        form.action = '/sales/' + ('{{ old("_id") }}');
        new bootstrap.Modal(document.getElementById('editSaleModal')).show();
    } else if (modalName === 'new-sale') {
        new bootstrap.Modal(document.getElementById('newSaleModal')).show();
    }
});
</script>
@endpush
@endsection