<?php

namespace App\Http\Controllers\SuperAdmin\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerAddFormRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    private Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index(Request $request)
    {
        try {

            $search  = trim((string) $request->query('search', ''));
            $perPage = (int) $request->query('perPage', 10);
            $perPage = max(1, min($perPage, 100));

            $query = $this->customer->newQuery();

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('cust_code', 'like', "%{$search}%")
                        ->orWhere('cust_name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            }

            $customers = $query
                ->orderByDesc('id')
                ->paginate($perPage)
                ->withQueryString();

            return view('pages.superadmin.customer.index', compact('customers'));

        } catch (\Throwable $e) {
            Log::error('[CustomerController@index] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load customers');
        }
    }

    public function create()
    {
        try {
            return view('pages.superadmin.customer.create');
        } catch (\Throwable $e) {
            Log::error('[CustomerController@create] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load create customer form');
        }
    }

    public function store(CustomerAddFormRequest $request)
    {
        try {
            $data = $request->validated();
            $data['processed_by'] = auth()->user()->username;
            $data['processed_date'] = date('Y-m-d H:i:s');

            $customer = $this->customer->create($data);

            return $this->successResponse($this->customer,'New customer stored successfully',  201);

        } catch (\Throwable $e) {
            Log::error('[CustomerController@store] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse('Failed to store new customer', 500);
        }
    }

    public function edit($id)
    {
        try {
            $customer = $this->customer->findOrFail($id);

            return view('pages.superadmin.customer.edit', compact('customer'));

        } catch (\Throwable $e) {
            Log::error('[CustomerController@edit] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to edit new customer');
        }
    }

    public function update( CustomerAddFormRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['processed_by'] = auth()->user()->username;
            $data['processed_date'] = date('Y-m-d H:i:s');

            $customer = $this->customer->findOrFail($id);
            $customer->update($data);

            return $this->successResponse( $customer, 'Customer updated successfully', 200 );

        } catch (\Throwable $e) {
            Log::error('[CustomerController@update] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse('Failed to update customer', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $customer = $this->customer->findOrFail($id);
            $customer->delete();

            return $this->successResponse( null, 'Customer deleted successfully', 200 );

        } catch (\Throwable $e) {
            Log::error('[CustomerController@destroy] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse('Failed to delete customer', 500);
        }
    }
}
