<nav class="sticky top-0 z-50 border-b border-sky-200/80 bg-white/90 shadow-sm backdrop-blur-md">
    <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('products.index') }}"
                class="text-xl font-bold tracking-tight text-sky-900 transition hover:text-emerald-700 sm:text-2xl">
                Shop
            </a>

            {{-- Desktop --}}
            <ul class="hidden items-center gap-1 text-sm font-medium text-gray-700 lg:flex lg:gap-2 lg:text-base">
                <li>
                    <a href="{{ route('products.index') }}" class="nav-link rounded-lg px-3 py-2">Home</a>
                </li>
                <li>
                    <a href="{{ route('cart.index') }}"
                        class="rounded-lg px-3 py-2 text-sky-800 transition hover:bg-sky-50 hover:text-emerald-700">Cart</a>
                </li>
                @auth
                    <li>
                        <a href="{{ route('orders.index') }}"
                            class="rounded-lg px-3 py-2 text-sky-800 transition hover:bg-sky-50 hover:text-emerald-700">My orders</a>
                    </li>
                @endauth
                @can('edit')
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="rounded-lg px-3 py-2 text-sky-800 transition hover:bg-sky-50">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('products.create') }}"
                            class="rounded-lg px-3 py-2 text-sky-800 transition hover:bg-sky-50">Add product</a>
                    </li>
                @endcan
                @auth
                    <li class="hidden border-l border-gray-200 pl-3 text-sm text-gray-500 xl:block">
                        <span class="font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="login cursor-pointer rounded-lg text-sm font-semibold">Logout</button>
                        </form>
                    </li>
                @endauth
                @guest
                    <li>
                        <a href="{{ route('showLogin') }}"
                            class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">Log
                            in</a>
                    </li>
                @endguest
            </ul>

            <button type="button" class="inline-flex cursor-pointer rounded-lg p-2 text-sky-900 hover:bg-sky-100 lg:hidden"
                id="hamburger" aria-expanded="false" aria-label="Open menu">
                <span class="text-2xl leading-none">&#9776;</span>
            </button>
        </div>

        {{-- Mobile --}}
        <div class="lg:hidden">
            <ul class="flex max-h-0 flex-col gap-1 overflow-hidden border-t border-transparent text-base transition-all duration-300 ease-in-out"
                id="menu">
                <li class="pt-2">
                    <a href="{{ route('products.index') }}" class="mobile-link block rounded-lg px-2 py-2">Home</a>
                </li>
                <li>
                    <a href="{{ route('cart.index') }}" class="mobile-link block rounded-lg px-2 py-2">Cart</a>
                </li>
                @auth
                    <li>
                        <a href="{{ route('orders.index') }}" class="mobile-link block rounded-lg px-2 py-2">My orders</a>
                    </li>
                @endauth
                @can('edit')
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="mobile-link block rounded-lg px-2 py-2">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('products.create') }}"
                            class="mobile-link block rounded-lg px-2 py-2">Add product</a>
                    </li>
                @endcan
                @auth
                    <li class="px-2 py-2 text-sm text-gray-600">
                        Signed in as <span class="font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="mobile-login w-full cursor-pointer rounded-lg text-center font-semibold">Log
                                out</button>
                        </form>
                    </li>
                @endauth
                @guest
                    <li class="pb-2">
                        <a href="{{ route('showLogin') }}"
                            class="mt-1 block rounded-lg bg-emerald-600 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-emerald-700">Log
                            in</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
