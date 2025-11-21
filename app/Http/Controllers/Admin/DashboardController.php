<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Inspection;
use App\Models\Payment;
use App\Models\TradeIn;
use App\Models\Warranty;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        // Overall Statistics
        $stats = [
            'total_users' => User::count(),
            'total_buyers' => User::where('role', 'buyer')->count(),
            'total_sellers' => User::where('role', 'seller')->count(),
            'total_workshops' => User::where('role', 'workshop')->count(),
            'total_products' => Product::count(),
            'pending_products' => Product::where('status', 'pending')->count(),
            'approved_products' => Product::where('status', 'approved')->count(),
            'rejected_products' => Product::where('status', 'rejected')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'delivered')->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'total_payments' => Payment::where('status', 'completed')->sum('amount'),
            'pending_inspections' => Inspection::where('status', 'pending')->count(),
            'pending_trade_ins' => TradeIn::where('status', 'pending')->count(),
        ];

        // Recent Orders (Last 10)
        $recentOrders = Order::with(['buyer'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Recent Users (Last 10)
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Sales Chart Data (Last 30 days)
        $salesData = $this->getSalesChartData();

        // Revenue Chart Data (Last 12 months)
        $revenueData = $this->getRevenueChartData();

        // Orders by Status Chart
        $ordersByStatus = $this->getOrdersByStatusChart();

        // Products by Status Chart
        $productsByStatus = $this->getProductsByStatusChart();

        return view('admin.dashboard.index', compact(
            'stats',
            'recentOrders',
            'recentUsers',
            'salesData',
            'revenueData',
            'ordersByStatus',
            'productsByStatus'
        ));
    }

    private function getSalesChartData()
    {
        $days = 30;
        $data = [];
        $labels = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('M d');
            
            $count = Order::whereDate('created_at', $date->toDateString())
                ->where('status', '!=', 'cancelled')
                ->count();
            
            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function getRevenueChartData()
    {
        $months = 12;
        $data = [];
        $labels = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');
            
            $revenue = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', '!=', 'cancelled')
                ->sum('total');
            
            $data[] = round($revenue, 2);
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function getOrdersByStatusChart()
    {
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];
        $data = [];
        $labels = [];

        foreach ($statuses as $status) {
            $count = Order::where('status', $status)->count();
            if ($count > 0) {
                $labels[] = ucfirst($status);
                $data[] = $count;
            }
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function getProductsByStatusChart()
    {
        $statuses = ['pending', 'approved', 'rejected'];
        $data = [];
        $labels = [];

        foreach ($statuses as $status) {
            $count = Product::where('status', $status)->count();
            if ($count > 0) {
                $labels[] = ucfirst($status);
                $data[] = $count;
            }
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}

