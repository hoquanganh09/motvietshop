<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');

        $query = Product::query()
            ->with(['images', 'kind', 'kind.category'])
            ->orderBy('stock', 'asc');

        if ($filter === 'low') {
            $query->where('stock', '>', 0)->where('stock', '<', 10);
        } elseif ($filter === 'out') {
            $query->where('stock', '<=', 0);
        }

        $products = $query->paginate(20)->appends($request->query());

        $totalLow = Product::where('stock', '>', 0)->where('stock', '<', 10)->count();
        $totalOut = Product::where('stock', '<=', 0)->count();
        $totalAll = Product::count();

        return view('admin.inventory.index', compact('products', 'filter', 'totalLow', 'totalOut', 'totalAll'));
    }
}
