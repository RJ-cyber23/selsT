@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-0 text-white">Products</h2>
        <p class="text-white-50 mb-0">{{ count($products) }} product(s) in inventory</p>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <form method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search products..." value="{{ $search ?? '' }}" style="min-width:0">
            @if($search)
                <a href="/products" class="btn btn-outline-secondary btn-sm flex-shrink-0">Clear</a>
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
            <i class="bi bi-plus-lg me-1"></i> Add Product
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

@if(count($products) > 0)
<div class="row g-3">
    @foreach($products as $product)
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="card-title fw-semibold mb-0">Product #{{ $product->product_id }}</h6>
                        <small class="text-muted">{{ $product->product_name ?? 'Unnamed' }}</small>
                    </div>
                    <span class="badge {{ ($product->quantity ?? 0) > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ ($product->quantity ?? 0) > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
                <table class="table table-sm table-borderless mb-0 small">
                    <tr><td class="text-muted ps-0">Size</td><td class="text-end pe-0">{{ $product->size ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">Quantity</td><td class="text-end pe-0">{{ $product->quantity ?? 0 }}</td></tr>
                    <tr><td class="text-muted ps-0">Weight</td><td class="text-end pe-0">{{ $product->weight ? $product->weight . ' kg' : 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">Brand</td><td class="text-end pe-0">{{ $product->brand_name ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">Category</td><td class="text-end pe-0">{{ $product->category_name ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted ps-0">Cost Price</td><td class="text-end pe-0">₱{{ number_format($product->cost_price ?? 0, 2) }}</td></tr>
                    <tr><td class="text-muted ps-0">Mark Up</td><td class="text-end pe-0">₱{{ number_format($product->mark_up ?? 0, 2) }}</td></tr>
                    <tr class="border-top"><td class="fw-semibold ps-0">Unit Price</td><td class="text-end pe-0 fw-bold text-primary">₱{{ number_format($product->unitPrice ?? 0, 2) }}</td></tr>
                </table>
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-outline-primary btn-sm flex-grow-1"
                        onclick="openEditModal(this)"
                        data-id="{{ $product->product_id }}"
                        data-product_name="{{ $product->product_name }}"
                        data-size="{{ $product->size }}"
                        data-category_id="{{ $product->category_id }}"
                        data-brand_id="{{ $product->brand_id }}"
                        data-quantity="{{ $product->quantity }}"
                        data-uom_id="{{ $product->uom_id }}"
                        data-weight="{{ $product->weight }}"
                        data-supplier_id="{{ $product->supplier_id }}"
                        data-cost_price="{{ $product->cost_price }}"
                        data-mark_up="{{ $product->mark_up }}">
                        Edit
                    </button>
                    <button class="btn btn-outline-danger btn-sm flex-grow-1"
                        onclick="openDeleteModal(this)"
                        data-id="{{ $product->product_id }}"
                        data-name="{{ $product->product_name }}">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-box-seam fs-1 text-white-50"></i>
    <h5 class="text-white mt-2">No products yet</h5>
    <p class="text-white-50">Start by adding a new product to your inventory.</p>
    <button class="btn btn-primary" onclick="openModal()">
        <i class="bi bi-plus-lg me-1"></i> Add Product
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

{{-- Add Product Modal --}}
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_modal" value="add-product">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Product Name</label>
                            <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name') }}">
                            @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Size</label>
                            <select name="size" class="form-select @error('size') is-invalid @enderror">
                                <option value="">Select</option>
                                <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ old('size') == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ old('size') == 'XL' ? 'selected' : '' }}>XL</option>
                            </select>
                            @error('size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Category</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Select category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->category_id }}" {{ old('category_id') == $cat->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Brand</label>
                            <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                <option value="">Select brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->brand_id }}" {{ old('brand_id') == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Quantity</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
                            @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">UOM</label>
                            <select name="uom_id" class="form-select @error('uom_id') is-invalid @enderror">
                                <option value="">Select</option>
                                @foreach($uoms as $uom)
                                    <option value="{{ $uom->uom_id }}" {{ old('uom_id') == $uom->uom_id ? 'selected' : '' }}>{{ $uom->uom_name }}</option>
                                @endforeach
                            </select>
                            @error('uom_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight') }}">
                            @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Supplier</label>
                            <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                                <option value="">Select</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_id }}" {{ old('supplier_id') == $supplier->supplier_id ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Cost Price (₱)</label>
                            <input type="number" step="0.01" name="cost_price" class="form-control @error('cost_price') is-invalid @enderror" value="{{ old('cost_price') }}">
                            @error('cost_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Mark Up (₱)</label>
                            <input type="number" step="0.01" name="mark_up" class="form-control @error('mark_up') is-invalid @enderror" value="{{ old('mark_up') }}">
                            @error('mark_up') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Product Modal --}}
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editProductForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="edit-product">
                <input type="hidden" name="_id" value="{{ old('_id') }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Product Name</label>
                            <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name') }}">
                            @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Size</label>
                            <select name="size" class="form-select @error('size') is-invalid @enderror">
                                <option value="">Select</option>
                                <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ old('size') == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ old('size') == 'XL' ? 'selected' : '' }}>XL</option>
                            </select>
                            @error('size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Category</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Select category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->category_id }}" {{ old('category_id') == $cat->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Brand</label>
                            <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                <option value="">Select brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->brand_id }}" {{ old('brand_id') == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Quantity</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
                            @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">UOM</label>
                            <select name="uom_id" class="form-select @error('uom_id') is-invalid @enderror">
                                <option value="">Select</option>
                                @foreach($uoms as $uom)
                                    <option value="{{ $uom->uom_id }}" {{ old('uom_id') == $uom->uom_id ? 'selected' : '' }}>{{ $uom->uom_name }}</option>
                                @endforeach
                            </select>
                            @error('uom_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight') }}">
                            @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Supplier</label>
                            <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                                <option value="">Select</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_id }}" {{ old('supplier_id') == $supplier->supplier_id ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Cost Price (₱)</label>
                            <input type="number" step="0.01" name="cost_price" class="form-control @error('cost_price') is-invalid @enderror" value="{{ old('cost_price') }}">
                            @error('cost_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Mark Up (₱)</label>
                            <input type="number" step="0.01" name="mark_up" class="form-control @error('mark_up') is-invalid @enderror" value="{{ old('mark_up') }}">
                            @error('mark_up') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Delete Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteProductName"></strong>?</p>
                <p class="text-muted small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteProductForm" method="POST">
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
    var modal = new bootstrap.Modal(document.getElementById('productModal'));
    modal.show();
}

function openEditModal(btn) {
    var form = document.getElementById('editProductForm');
    form.action = '/products/' + btn.dataset.id;

    form.querySelector('[name="product_name"]').value = btn.dataset.product_name || '';
    form.querySelector('[name="size"]').value = btn.dataset.size || '';
    form.querySelector('[name="category_id"]').value = btn.dataset.category_id || '';
    form.querySelector('[name="brand_id"]').value = btn.dataset.brand_id || '';
    form.querySelector('[name="quantity"]').value = btn.dataset.quantity || '';
    form.querySelector('[name="uom_id"]').value = btn.dataset.uom_id || '';
    form.querySelector('[name="weight"]').value = btn.dataset.weight || '';
    form.querySelector('[name="supplier_id"]').value = btn.dataset.supplier_id || '';
    form.querySelector('[name="cost_price"]').value = btn.dataset.cost_price || '';
    form.querySelector('[name="mark_up"]').value = btn.dataset.mark_up || '';

    var modal = new bootstrap.Modal(document.getElementById('editProductModal'));
    modal.show();
}

function openDeleteModal(btn) {
    document.getElementById('deleteProductForm').action = '/products/' + btn.dataset.id;
    document.getElementById('deleteProductName').textContent = btn.dataset.name || 'this product';
    var modal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    var modalName = '{{ old("_modal") }}';
    if (modalName === 'edit-product') {
        var form = document.getElementById('editProductForm');
        form.action = '/products/' + ('{{ old("_id") }}');
        new bootstrap.Modal(document.getElementById('editProductModal')).show();
    } else if (modalName === 'add-product') {
        new bootstrap.Modal(document.getElementById('productModal')).show();
    }
});
</script>
@endpush
@endsection

