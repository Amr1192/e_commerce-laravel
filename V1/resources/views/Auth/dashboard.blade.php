@extends('layout')

@section('title', 'Admin Dashboard')

@section('body', 'bg-gray-50')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                <p class="mt-2 text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Interactive Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg cursor-pointer hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-blue-500" 
                 onclick="toggleCardData('users')" id="users-card">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">👥 Total Users</dt>
                                    <dd class="text-2xl font-bold text-gray-900" id="users-main-count">{{ number_format($totalUsers) }}</dd>
                                    <dd class="text-xs text-gray-400">Users</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" id="users-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Hidden detailed data -->
                    <div class="mt-4 hidden" id="users-details">
                        <div class="border-t pt-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">📊 User Statistics</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <div class="text-blue-600 font-medium flex items-center">
                                        <span class="mr-1">📅</span> New Today
                                    </div>
                                    <div class="text-blue-800 text-lg font-bold">{{ number_format($todayUsers) }}</div>
                                    <div class="text-xs text-blue-600">users registered today</div>
                                </div>
                                <div class="bg-green-50 p-3 rounded-lg">
                                    <div class="text-green-600 font-medium flex items-center">
                                        <span class="mr-1">✅</span> Active Users
                                    </div>
                                    <div class="text-green-800 text-lg font-bold">{{ number_format($activeUsers) }}</div>
                                    <div class="text-xs text-green-600">users with cart activity</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Products Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg cursor-pointer hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-green-500" 
                 onclick="toggleCardData('products')" id="products-card">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">📦 Total Products</dt>
                                    <dd class="text-2xl font-bold text-gray-900" id="products-main-count">{{ number_format($totalProducts) }}</dd>
                                    <dd class="text-xs text-gray-400">Products</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" id="products-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Hidden detailed data -->
                    <div class="mt-4 hidden" id="products-details">
                        <div class="border-t pt-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">📦 Product Statistics</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="bg-green-50 p-3 rounded-lg">
                                    <div class="text-green-600 font-medium flex items-center">
                                        <span class="mr-1">📅</span> Added Today
                                    </div>
                                    <div class="text-green-800 text-lg font-bold">{{ number_format($todayProducts) }}</div>
                                    <div class="text-xs text-green-600">new products today</div>
                                </div>
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <div class="text-blue-600 font-medium flex items-center">
                                        <span class="mr-1">🏷️</span> Categories
                                    </div>
                                    <div class="text-blue-800 text-lg font-bold">{{ number_format($totalCategories) }}</div>
                                    <div class="text-xs text-blue-600">product categories</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Categories Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg cursor-pointer hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-yellow-500" 
                 onclick="toggleCardData('categories')" id="categories-card">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">🏷️ Categories</dt>
                                    <dd class="text-2xl font-bold text-gray-900" id="categories-main-count">{{ number_format($totalCategories) }}</dd>
                                    <dd class="text-xs text-gray-400">Products Categories</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" id="categories-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Hidden detailed data -->
                    <div class="mt-4 hidden" id="categories-details">
                        <div class="border-t pt-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">🏷️ Category Information</h4>
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <div class="text-yellow-600 font-medium flex items-center mb-2">
                                    <span class="mr-2">📊</span> Total Categories
                                </div>
                                <div class="text-yellow-800 text-2xl font-bold mb-2">{{ number_format($totalCategories) }}</div>
                                <div class="text-xs text-yellow-700">Product classification groups to organize your inventory</div>
                                <div class="mt-3 text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded">
                                    💡 Tip: Categories help customers find products easily
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Cart Items Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg cursor-pointer hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-purple-500" 
                 onclick="toggleCardData('carts')" id="carts-card">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">🛒 Cart Items</dt>
                                    <dd class="text-2xl font-bold text-gray-900" id="carts-main-count">{{ number_format($totalCarts) }}</dd>
                                    <dd class="text-xs text-gray-400">Items in carts</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" id="carts-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Hidden detailed data -->
                    <div class="mt-4 hidden" id="carts-details">
                        <div class="border-t pt-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">🛒 Cart Activity</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="bg-purple-50 p-3 rounded-lg">
                                    <div class="text-purple-600 font-medium flex items-center">
                                        <span class="mr-1">📅</span> Added Today
                                    </div>
                                    <div class="text-purple-800 text-lg font-bold">{{ number_format($todayCarts) }}</div>
                                    <div class="text-xs text-purple-600">items added to carts today</div>
                                </div>
                                <div class="bg-indigo-50 p-3 rounded-lg">
                                    <div class="text-indigo-600 font-medium flex items-center">
                                        <span class="mr-1">📊</span> Total Items
                                    </div>
                                    <div class="text-indigo-800 text-lg font-bold">{{ number_format($totalCarts) }}</div>
                                    <div class="text-xs text-indigo-600">items in all shopping carts</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Recent Users -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Users</h3>
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @forelse($recentUsers as $user)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                                    </div>
                                    <div class="flex-shrink-0 text-sm text-gray-500">
                                        {{ $user->created_at }}
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="py-4 text-center text-gray-500">No users found</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Products -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Products</h3>
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @forelse($recentProducts as $product)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                            <img src="{{ $product->image }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ $product->category->name ?? 'No Category' }} • ${{ number_format($product->price, 2) }}</p>
                                    </div>
                                    <div class="flex-shrink-0 text-sm text-gray-500">
                                        {{ $product->created_at }}
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="py-4 text-center text-gray-500">No products found</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!-- Top Selling Products -->
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Top Selling Products</h3>
                <div class="flow-root">
                    <ul class="-my-5 divide-y divide-gray-200">
                        @forelse($topSellingProducts as $product)
                        <li class="py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                             <img src="{{ $product->image }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ $product->category->name ?? 'No Category' }}</p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 text-sm text-gray-900 font-medium">
                                    {{ $product->carts_sum_quantity ?? 0 }} sold
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="py-4 text-center text-gray-500">No sales data available</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Product
                    </a>
                    <a href="/" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Store
                    </a>
                    <a href="/cart" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                        View Cart
                    </a>
                    <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Analytics
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCardData(cardType) {
    const detailsElement = document.getElementById(cardType + '-details');
    const arrowElement = document.getElementById(cardType + '-arrow');
    
    if (detailsElement.classList.contains('hidden')) {
        // Show details
        detailsElement.classList.remove('hidden');
        arrowElement.style.transform = 'rotate(180deg)';
        
        // Add smooth animation
        detailsElement.style.opacity = '0';
        detailsElement.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
            detailsElement.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            detailsElement.style.opacity = '1';
            detailsElement.style.transform = 'translateY(0)';
        }, 10);
    } else {
        // Hide details
        detailsElement.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        detailsElement.style.opacity = '0';
        detailsElement.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
            detailsElement.classList.add('hidden');
            arrowElement.style.transform = 'rotate(0deg)';
        }, 300);
    }
}

// Add click animation to cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('[onclick^="toggleCardData"]');
    
    cards.forEach(card => {
        card.addEventListener('click', function() {
            // Add a subtle click effect
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
});
</script>
@endsection
