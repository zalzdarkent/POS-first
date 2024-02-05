<?php

namespace Modules\Sale\Http\Controllers;

use Modules\Sale\Entities\Sale;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\DataTables\LeaderboardDataTable;

class LeaderboardController extends Controller
{
    public function showLeaderboard(LeaderboardDataTable $dataTable)
    {
        $products = SaleDetails::select('product_id', 'product_name')
            ->selectRaw('SUM(quantity) as total_quantity_sold')
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [date('Y-m')])
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_quantity_sold')
            ->get();

        return $dataTable->render('sale::leaderboard.index');
    }
}
