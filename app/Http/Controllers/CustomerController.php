<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerSaleInvoice;
use App\Models\CustomerSalePayments;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $customers = Customer::where('merchant_id', $merchantId)
            ->orderBy('id', 'desc')
            ->paginate(20);

        // Attach total_debts to each customer
        $customers->getCollection()->transform(function ($row) {
            $row->total_debts = $this->calculateCustomerDebt($row->id);
            return $row;
        });

        return response()->json($customers);
    }

    // Helper function to calculate total debts for a customer
    protected function calculateCustomerDebt($customer_id)
    {
        // Get all sales invoices for this customer
        $invoices = CustomerSaleInvoice::where('customer_id', $customer_id)->get();

        // Sum total_price of invoices
        $total_price = $invoices->sum('total_price');

        // Get all invoice IDs
        $invoiceIds = $invoices->pluck('id');

        // Sum all payments for these invoices
        $total_paid = CustomerSalePayments::whereIn('customer_sale_invoice_id', $invoiceIds)->sum('amount');

        // Return debts (will be 0 if none)
        return max(0, $total_price - $total_paid);
    }


    // Store new customer
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_link'  => 'required|string',
            'phone1'         => 'required|string|max:50|unique:customers,phone1',
            'phone2'         => 'nullable|string|max:50|unique:customers,phone2',
            'state'          => 'nullable|string|max:100',
            'city'           => 'nullable|string|max:100',
            'sponsor_name'   => 'nullable|string|max:255',
            'sponsor_phone'  => 'nullable|string|max:20',
        ]);

        $data['merchant_id'] = auth()->user()->merchant_id;
        $customer = Customer::create($data);

        return response()->json([
            'status' => 'ok',
            'msg'    => 'Customer added successfully.',
            'data'   => $customer,
        ]);
    }

    // Update customer
    public function update(Request $request)
    {
        $data = $request->validate([
            'customerId'     => 'required|exists:customers,id',
            'customer_name'  => 'required|string|max:255',
            'customer_link'  => 'required|string',
            'phone1'         => 'required|string|max:50|unique:customers,phone1,' . $request->customerId,
            'phone2'         => 'nullable|string|max:50|unique:customers,phone2,' . $request->customerId,
            'state'          => 'nullable|string|max:100',
            'city'           => 'nullable|string|max:100',
            'sponsor_name'   => 'nullable|string|max:255',
            'sponsor_phone'  => 'nullable|string|max:20',
        ]);

        $merchantId = auth()->user()->merchant_id;
        $customer = Customer::where('id', $data['customerId'])
            ->where('merchant_id', $merchantId)
            ->firstOrFail();
        $customer->update([
            'customer_name' => $data['customer_name'],
            'customer_link' => $data['customer_link'],
            'phone1'        => $data['phone1'],
            'phone2'        => $data['phone2'],
            'state'         => $data['state'],
            'city'          => $data['city'],
            'sponsor_name'  => $data['sponsor_name'] ?? null,
            'sponsor_phone' => $data['sponsor_phone'] ?? null,
        ]);

        return response()->json([
            'status' => 'ok',
            'msg'    => 'Customer updated successfully.',
            'data'   => $customer,
        ]);
    }

    // Delete customer
    public function delete(Request $request)
    {
        $request->validate([
            'customerId' => 'required|exists:customers,id',
        ]);

        $merchantId = auth()->user()->merchant_id;
        $customer = Customer::where('id', $request->customerId)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();
        $customer->delete();

        return response()->json([
            'status' => 'ok',
            'msg'    => 'Customer deleted successfully.',
        ]);
    }
}

