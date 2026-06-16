<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use App\DTOs\CustomerDTO;
use App\Services\CustomerCRUDService;
use App\Http\Requests\StoreCustomerRequest;

class CustomerController extends Controller
{
    private CustomerCRUDService $customerCRUDService;

    public function __construct(CustomerCRUDService $customerCRUDService)
    {
        $this->customerCRUDService = $customerCRUDService;
    }

    public function __invoke()
    {
        $search = request('search');
        $perPage = request('perPage', 10);
        if ($perPage === 'all') { $perPage = 999999; }
        $page = max(1, (int) request('page', 1));
        return view('reference.customers', $this->customerCRUDService->read($page, (int) $perPage, (int) session('user_id'), $search));
    }

    public function store(StoreCustomerRequest $request)
    {
        $this->customerCRUDService->create(new CustomerDTO(...$request->validated()), (int) session('user_id'));
        return redirect('/customers')->with('success', 'Customer added successfully!');
    }

    public function update(StoreCustomerRequest $request, int $id)
    {
        $this->customerCRUDService->update($id, new CustomerDTO(...$request->validated()));
        return redirect('/customers')->with('success', 'Customer updated successfully!');
    }

    public function destroy(int $id)
    {
        $this->customerCRUDService->delete($id);
        return redirect('/customers')->with('success', 'Customer deleted successfully!');
    }
}
