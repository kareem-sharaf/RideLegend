<x-auth-layout title="Login">
    <x-card>
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Sign in to your account</h2>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <x-form-input
                label="Email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
            />

            <x-form-input
                label="Password"
                name="password"
                type="password"
                required
            />

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-800">
                    Forgot password?
                </a>
            </div>

            <div>
                <x-button type="submit" variant="primary" class="w-full">
                    Sign in
                </x-button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-800 font-medium">
                        Register here
                    </a>
                </p>
            </div>
        </form>
    </x-card>
</x-auth-layout>

