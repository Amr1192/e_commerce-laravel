@extends('layout')
@section('title','signup')
@section('html','h-full bg-white')
@section('body','h-full')
@section('content')

<div class="px-6 py-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Create a new account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form action="/signup" method="POST" class="space-y-6">
        @csrf
      <div>
        <label for="username" class="label">username</label>
        <div class="mt-2">
          <input id="username" type="text" name="name" required autocomplete="username" value="{{ old('name') }}" class="input" />
        </div>
                @error('name')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
        <label for="email" class="label">Email address</label>
        <div class="mt-2">
          <input id="email" type="email" name="email" required autocomplete="email" value="{{ old(key: 'email') }}" class="input" />
        </div>
        @error('email')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="label">Password</label>
        </div>
        <div class="mt-2">
          <input id="password" type="password" name="password" required class="input" />
        </div>
                @error('password')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
        <label for="confirm" class="label">Confirm password</label>
          <div class="mt-2">
          <input id="confirm" type="password" name="password_confirmation" required class="input" />
        </div>

      </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create an account</button>
      </div>
    </form>
     <div class="text-sm mt-5 flex justify-between">
       <p class=" text-center text-sm/6 text-gray-500">
         Already a member?
         <a href="/login" class="font-semibold text-indigo-600 hover:text-indigo-500">Log in</a>
       </p>
          

    </div>
  </div>
</div>

@endsection

