<?php

namespace App\Http\Controllers;

use App\Models\transaction_details;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactionDetails = transaction_details::with('transaction', 'product')->latest()->get();
        return view('transaction_details.index', compact('transactionDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transactions = Transactions::all();
        $products = Product::all();
        return view('transaction_details.create', compact('transactions', 'products'));
    }

    public function showByTransaction($transaction_Id)
    {
        $transactionDetails = transaction_details::with('product')
            ->where('transaction_id', $transaction_Id)
            ->get();

        return view('transaction_details.show', compact('transactionDetails'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(transaction_details $transaction_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaction_details $transaction_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transaction_details $transaction_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaction_details $transaction_details)
    {
        //
    }
}
