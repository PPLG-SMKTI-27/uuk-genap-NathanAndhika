<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\TransactionDetails;
use App\Models\Products;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Transactions::query();
        if ($search) {
            $query->where('transaction_no', 'like', '%' . $search . '%')
                ->orWhere('customer_name', 'like', '%' . $search . '%');
        }

        $transactions = $query->latest()->paginate(10);

        return view('transactions.index', compact('transactions', 'search'));
    }

    public function create()
    {
        $categories = \App\Models\Categories::all();
        $products = Products::where('stock', '>', 0)->get();
        $transactionNo = 'TX-' . date('Ymd') . '-' . (Transactions::count() + 1);

        return view('transactions.create', compact('categories', 'products', 'transactionNo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_no' => 'required|unique:transactions,transaction_no',
            'date' => 'required|date',
            'customer_name' => 'nullable|string|max:255',
            'status' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
    }

    public function show(Transactions $transactions)
    {
        //
    }

    public function edit(Transactions $transactions)
    {
        $transactionDetails = $transactions->transactionDetails()->with('product')->get();
        return view('transactions.edit', compact('transactions', 'transactionDetails'));
    }

    public function update(Request $request, Transactions $transactions)
    {
        $transactions->update([
            'total_price' => $totalPrice
        ]);
    }

    public function destroy(Transactions $transactions)
    {
        //
    }
}
