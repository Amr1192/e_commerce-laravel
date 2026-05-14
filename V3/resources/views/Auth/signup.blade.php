@extends('layout')

@section('title', 'Create account')

@section('html', 'h-full scroll-smooth')

@section('body', 'min-h-screen flex flex-col bg-gradient-to-br from-slate-50 via-white to-emerald-50')

@section('content')
    <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6">
        <div class="mx-auto w-full max-w-md">
            <div class="rounded-2xl border border-gray-200/80 bg-white/90 p-8 shadow-xl shadow-gray-900/5 ring-1 ring-gray-900/5 backdrop-blur-sm sm:p-10">
                <div class="text-center">
                    <a href="{{ route('products.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">←
                        Back to shop</a>
                    <h1 class="mt-6 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Create account</h1>
                    <p class="mt-2 text-sm text-gray-600">Join to save your cart and track orders.</p>
                </div>

                <form action="{{ route('signup') }}" method="POST" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="label">Full name</label>
                        <div class="mt-2">
                            <input id="name" type="text" name="name" required autocomplete="name" value="{{ old('name') }}"
                                class="input" />
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="label">Email</label>
                        <div class="mt-2">
                            <input id="email" type="email" name="email" required autocomplete="email" value="{{ old('email') }}"
                                class="input" />
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="label">Password</label>
                        <div class="mt-2">
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="input" />
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="label">Confirm password</label>
                        <div class="mt-2">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                autocomplete="new-password" class="input" />
                        </div>
                    </div>

                    <button type="submit"
                        class="flex w-full min-h-[48px] items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                        Create account
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('showLogin') }}" class="font-semibold text-emerald-700 hover:text-emerald-900">Sign in</a>
                </p>
            </div>
        </div>
    </div>
@endsection
