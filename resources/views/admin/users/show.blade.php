<x-admin-layout title="User Details">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-primary-600 hover:text-primary-800 mb-4 inline-block">
            ← Back to Users
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Info -->
        <div class="lg:col-span-2">
            <x-card>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">User Information</h2>
                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                       class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                        Edit User
                    </a>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-20 h-20 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                            <span class="text-2xl text-primary-600 font-bold">
                                {{ strtoupper(substr($user->first_name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                        <div>
                            <p class="text-sm text-gray-500">Role</p>
                            <p class="text-lg font-medium text-gray-900">
                                <x-badge variant="info">{{ ucfirst($user->role) }}</x-badge>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="text-lg font-medium text-gray-900">
                                @if($user->email_verified_at)
                                    <x-badge variant="success">Active</x-badge>
                                @else
                                    <x-badge variant="warning">Inactive</x-badge>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="text-lg font-medium text-gray-900">{{ $user->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Joined</p>
                            <p class="text-lg font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Roles & Permissions -->
            <x-card class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Roles & Permissions</h3>
                <div class="space-y-2">
                    @forelse($user->roles as $role)
                        <x-badge variant="info">{{ $role->name }}</x-badge>
                    @empty
                        <p class="text-gray-500">No roles assigned</p>
                    @endforelse
                </div>
            </x-card>
        </div>

        <!-- Statistics -->
        <div>
            <x-card>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistics</h3>
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-600">Total Products</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-gray-600">Total Orders</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['total_orders'] }}</p>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-lg">
                        <p class="text-sm text-gray-600">Total Spent</p>
                        <p class="text-2xl font-bold text-purple-600">${{ number_format($stats['total_spent'], 2) }}</p>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-admin-layout>

