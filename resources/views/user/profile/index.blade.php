<x-dashboard-layout title="Profile">
    <div class="max-w-4xl mx-auto">
        <x-card>
            <div class="flex items-center space-x-6 mb-6">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover">
                @else
                    <div class="w-24 h-24 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-3xl text-primary-800 font-semibold">
                            {{ strtoupper(substr(auth()->user()->email, 0, 1)) }}
                        </span>
                    </div>
                @endif
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>
                    <p class="text-gray-600">{{ auth()->user()->email }}</p>
                    <x-badge variant="info" class="mt-2">{{ ucfirst(auth()->user()->role) }}</x-badge>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Information</h3>
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">First Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->first_name ?? 'Not set' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->last_name ?? 'Not set' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->phone ?? 'Not set' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-6 flex space-x-4">
                <x-button href="{{ route('profile.edit') }}" variant="primary">Edit Profile</x-button>
                <x-button href="{{ route('profile.settings') }}" variant="secondary">Settings</x-button>
            </div>
        </x-card>
    </div>
</x-dashboard-layout>

