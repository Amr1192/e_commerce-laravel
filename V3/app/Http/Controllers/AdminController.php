<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'productCount' => Product::query()->count(),
            'userCount' => User::query()->count(),
            'orderCount' => Order::query()->count(),
        ]);
    }
}
