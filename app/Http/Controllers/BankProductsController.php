<?php

namespace App\Http\Controllers;

use App\Models\BankProduct;
use Illuminate\Http\Request;

class BankProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $bankProducts = BankProduct::all();

        return view('client-panel.bank-products.index', compact('bankProducts'));
    }
}
