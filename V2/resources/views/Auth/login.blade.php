@extends('layout')
@section('title','login')
@section('html','h-full bg-white')
@section('body','h-full')
@section('content')

<div class="px-6 py-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form action="/login" method="POST" class="space-y-6">
        @csrf
      <div>
        <label for="email" class="label">Email address</label>
        <div class="mt-2">
          <input id="email" type="email" name="email" required autocomplete="email" value="{{ old('email') }}" class="input" />
        </div>
        @error('email')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="label">Password</label>
          <div class="text-sm">
            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
          </div>
        </div>
        <div class="mt-2">
          <input id="password" type="password" name="password" required autocomplete="current-password" class="input" />
        </div>
                @error('password')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
      </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6 text-gray-500">
      Not a member yet?
      <a href="/signup" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign up</a>
    </p>
  </div>
</div>

@endsection

