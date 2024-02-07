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
        return $dataTable->render('sale::leaderboard.index');
    }
}