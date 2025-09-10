<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
  public function index()
  {
    // Get dashboard statistics (optimized for large datasets)
    $totalUsers = User::count();
    $totalProducts = Product::count();
    $totalCategories = Category::count();
    $totalCarts = Cart::count();

    // Get recent users (last 5) - optimized query
    $recentUsers = User::select('id', 'name', 'email', 'created_at')
      ->latest()
      ->take(5)
      ->get();

    // Get recent products (last 5) - optimized query
    $recentProducts = Product::select('id', 'name', 'price', 'created_at', 'category_id')
      ->with(['category:id,name'])
      ->latest()
      ->take(5)
      ->get();

    // Get top selling products (by cart quantity) - optimized for large datasets
    $topSellingProducts = Product::select('id', 'name', 'category_id')
      ->with(['category:id,name'])
      ->withSum('carts', 'quantity')
      ->orderBy('carts_sum_quantity', 'desc')
      ->take(5)
      ->get();

    // Get monthly sales data (last 6 months) - optimized query
    $monthlySales = Cart::select(
      DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
      DB::raw('SUM(quantity) as total_quantity'),
      DB::raw('COUNT(*) as total_orders')
    )
      ->where('created_at', '>=', now()->subMonths(6))
      ->groupBy('month')
      ->orderBy('month')
      ->get();

    // Get user registration data (last 6 months) - optimized query
    $monthlyRegistrations = User::select(
      DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
      DB::raw('COUNT(*) as total_users')
    )
      ->where('created_at', '>=', now()->subMonths(6))
      ->groupBy('month')
      ->orderBy('month')
      ->get();

    // Get additional statistics for interactive cards
    $todayUsers = User::whereDate('created_at', today())->count();
    $todayProducts = Product::whereDate('created_at', today())->count();
    $todayCarts = Cart::whereDate('created_at', today())->count();
    $activeUsers = User::whereHas('carts')->count();

    return view('Auth.dashboard', compact(
      'totalUsers',
      'totalProducts',
      'totalCategories',
      'totalCarts',
      'recentUsers',
      'recentProducts',
      'topSellingProducts',
      'monthlySales',
      'monthlyRegistrations',
      'todayUsers',
      'todayProducts',
      'todayCarts',
      'activeUsers'
    ));
  }
}
