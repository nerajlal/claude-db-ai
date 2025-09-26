@extends('layouts.guest')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-chat-gray">
    <div class="w-full max-w-md p-8 space-y-6 bg-white dark:bg-chat-sidebar rounded-lg shadow-lg">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Your Account</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Join to start your SQL journey</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="firstname" class="text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                    <input id="firstname" name="firstname" type="text" value="{{ old('firstname') }}" required autocomplete="given-name"
                           class="mt-1 w-full px-3 py-2 bg-gray-100 dark:bg-chat-input border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                    @error('firstname')
                        <span class="text-xs text-red-500 mt-1" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div>
                    <label for="lastname" class="text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                    <input id="lastname" name="lastname" type="text" value="{{ old('lastname') }}" required autocomplete="family-name"
                           class="mt-1 w-full px-3 py-2 bg-gray-100 dark:bg-chat-input border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                    @error('lastname')
                        <span class="text-xs text-red-500 mt-1" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="phone" class="text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required autocomplete="tel"
                       class="mt-1 w-full px-3 py-2 bg-gray-100 dark:bg-chat-input border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                @error('phone')
                    <span class="text-xs text-red-500 mt-1" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div>
                <label for="password" class="text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                       class="mt-1 w-full px-3 py-2 bg-gray-100 dark:bg-chat-input border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                @error('password')
                    <span class="text-xs text-red-500 mt-1" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div>
                <label for="password-confirm" class="text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                <input id="password-confirm" name="password_confirmation" type="password" required autocomplete="new-password"
                       class="mt-1 w-full px-3 py-2 bg-gray-100 dark:bg-chat-input border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-white">
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-br from-green-400 to-blue-500 hover:bg-gradient-to-bl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
        <div class="text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</div>
@endsection