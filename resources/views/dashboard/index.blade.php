<x-dashboard-layout title="Dashboard">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Welcome</h3>
            <p class="text-3xl font-bold text-primary-800">{{ auth()->user()->first_name ?? 'User' }}</p>
        </x-card>
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Role</h3>
            <p class="text-2xl font-bold text-gray-900">{{ ucfirst(auth()->user()->role) }}</p>
        </x-card>
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Status</h3>
            <x-badge variant="success">Active</x-badge>
        </x-card>
    </div>

    <x-card>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-button href="{{ route('profile.show') }}" variant="primary" class="w-full">View Profile</x-button>
            <x-button href="{{ route('profile.edit') }}" variant="secondary" class="w-full">Edit Profile</x-button>
        </div>
    </x-card>
</x-dashboard-layout>

