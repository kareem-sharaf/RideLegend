<x-auth-layout title="Register">
    <x-card>
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Create your account</h2>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <x-form-input
                    label="First Name"
                    name="first_name"
                    type="text"
                    value="{{ old('first_name') }}"
                />

                <x-form-input
                    label="Last Name"
                    name="last_name"
                    type="text"
                    value="{{ old('last_name') }}"
                />
            </div>

            <x-form-input
                label="Email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
            />

            <x-form-input
                label="Phone"
                name="phone"
                type="tel"
                value="{{ old('phone') }}"
            />

            <x-form-input
                label="Password"
                name="password"
                type="password"
                required
            />

            <x-form-input
                label="Confirm Password"
                name="password_confirmation"
                type="password"
                required
            />

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Role
                </label>
                <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="buyer" {{ old('role', 'buyer') === 'buyer' ? 'selected' : '' }}>Buyer</option>
                    <option value="seller" {{ old('role') === 'seller' ? 'selected' : '' }}>Seller</option>
                    <option value="workshop" {{ old('role') === 'workshop' ? 'selected' : '' }}>Workshop</option>
                </select>
            </div>

            <div>
                <x-button type="submit" variant="primary" class="w-full">
                    Register
                </x-button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-800 font-medium">
                        Sign in here
                    </a>
                </p>
            </div>
        </form>
    </x-card>
</x-auth-layout>

