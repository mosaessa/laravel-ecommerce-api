<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Transaction $transaction)
    {

        // return $transaction->product->categories;
        return $this->showAll($transaction->product->categories);
    }
}
