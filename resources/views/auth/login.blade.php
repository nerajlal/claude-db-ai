@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-chat-gray">
    <div class="w-full max-w-md p-8 space-y-8 bg-white dark:bg-chat-sidebar rounded-lg shadow-lg">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome to SQL Assistant</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Please sign in to continue</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="phone" class="text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                <div class="mt-1">
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required autocomplete="phone" autofocus
                           class="w-full px-3 py-2 bg-gray-100 dark:bg-chat-input border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                    @error('phone')
                        <span class="text-xs text-red-500 mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password" class="text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                           class="w-full px-3 py-2 bg-gray-100 dark:bg-chat-input border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                    @error('password')
                        <span class="text-xs text-red-500 mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-br from-green-400 to-blue-500 hover:bg-gradient-to-bl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection