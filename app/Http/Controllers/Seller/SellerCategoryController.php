<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        return $this->showAll(
            $seller
                ->products()
                ->whereHas('categories')
                ->with('categories')
                ->get()
                ->pluck('categories')
                ->collapse()
                ->unique('id')
                ->values()
        );
    }
}
