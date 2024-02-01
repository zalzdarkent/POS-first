<?php

namespace Modules\Sale\Http\Controllers;

use Modules\Sale\Entities\Sale;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LeaderboardController extends Controller
{
    public function showLeaderboard()
    {
        $products = DB::table('products')
            ->leftJoin('sales', 'products.id', '=', 'sales.product_id')
            ->select('products.id', 'products.product_name', 'products.product_quantity', DB::raw('SUM(IFNULL(sales.quantity, 0)) as total_sold'))
            ->groupBy('products.id', 'products.product_name', 'products.product_quantity')
            ->orderByDesc('total_sold')
            ->get();

        return view('leaderboard.index', compact('sales'));
    }
}
