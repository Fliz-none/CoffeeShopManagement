<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Detail;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Variable;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    const NAME = 'bảng tin';

    // public function __construct()
    // {
    //     parent::__construct();
    //     if ($this->user === null) {
    //         $this->user = Auth::user();
    //     }
    //     $this->middleware(['admin', 'auth']);
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pageName = 'Bảng tin';
        return view('admin.dashboard', compact('pageName'));
    }

    public function load(Request $request)
    {
        $range = explode(' - ', $request->range);
        $start = DateTime::createFromFormat('d/m/Y', $range[0]);
        $end = DateTime::createFromFormat('d/m/Y', $range[1]);
        $period = $request->get('period', 'day'); // Mặc định là 'day' nếu không có giá trị

        // Tùy theo 'period' sẽ lấy dữ liệu theo ngày, tháng, quý hoặc năm
        switch ($period) {
            case 'month':
                $dateFormat = 'DATE_FORMAT(created_at, "%Y-%m")';
                break;
            case 'quarter':
                $dateFormat = 'CONCAT("Quý ", QUARTER(created_at), "/", YEAR(created_at))';
                break;
            case 'year':
                $dateFormat = 'YEAR(created_at)';
                break;
            default:
                $dateFormat = 'DATE(created_at)';
        }

        // Tổng doanh thu trong khoảng từ $start đến $end
        $totalRevenue = Transaction::whereBetween('created_at', [$start, $end])
            ->where('company_id', Auth::user()->company_id)
            ->sum('amount');

        // Tổng đơn hàng trong khoảng từ $start đến $end
        $totalOrder = Order::whereBetween('created_at', [$start, $end])
            ->where('company_id', Auth::user()->company_id)
            ->count('id');

        // Lấy số sản phẩm bán được trong khoảng từ $start đến $end
        $totalProduct = Detail::whereBetween('created_at', [$start, $end])
            ->sum('quantity');

        // Lấy object chứa doanh thu và thời gian (theo ngày/tháng/quý/năm) diễn ra giao dịch
        $revenueChart = Transaction::select(DB::raw("$dateFormat as created_at"), DB::raw('SUM(amount) as revenue'))
            ->whereBetween('created_at', [$start, $end])
            ->where('company_id', Auth::user()->company_id)
            ->groupBy(DB::raw($dateFormat))
            ->pluck('revenue', 'created_at');

        $response = array(
            'total_revenue' => $totalRevenue,
            'total_product' => $totalProduct,
            'total_order' => $totalOrder,
            'revenue_chart' => $revenueChart,
        );

        return response()->json($response);
    }
}
