@vite(['resources/js/app.js','resources/css/app.css'])
 <nav class="bg-sky-100 shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <!-- Desktop Layout -->
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="text-2xl font-bold text-sky-800">
                    <a href="/" class="hover:text-sky-600 transition-colors">Logo</a>
                </div>
                
                <!-- Desktop Menu -->
                <ul class="hidden lg:flex lg:gap-8 text-lg items-center">
                    <li><a href="/" class="nav-link">Home</a></li>
                    @can('edit')
                                            <li><a href="/dashboard" class="nav-link">Dashboard</a></li>
                                            <li><a href="/products/create" class="nav-link">Create</a></li>


                    @endcan
                    @auth
                                            <li><a href="/" class="nav-link">Welcome, {{ auth()->user()->name }}</a></li>

                    @endauth
                    <li><a href="/cart" class="nav-link">Cart</a></li>
                    @guest
                         <li><a href={{ route('showLogin') }} class="login">Log In</a></li>

                    @endguest
                    @auth
                        <li>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="login cursor-pointer">Logout</button>
                            </form>
                        </li>

                    @endauth
                </ul>
                
                <!-- Mobile Hamburger -->
                <button class="lg:hidden text-3xl text-sky-800 hover:text-sky-600 transition-colors" id="hamburger">&#9776;</button>
            </div>
            
            <!-- Mobile Menu -->
            <div class="lg:hidden">
                <ul class="flex flex-col gap-4 text-lg mt-4 h-0 overflow-hidden transition-all duration-300 ease-in-out" id="menu">
                    <li><a href="/" class="mobile-link">Home</a></li>
                    <li><a href="/cart" class="mobile-link">Cart</a></li>
                    @auth
                    <form action="/logout" method="POST">
                        @csrf
                          <button type="submit" class="mobile-login">Log out</button>
                        </form>
                    @endauth
                    @guest
                    <li><a href="" class="mobile-login">Log In</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>