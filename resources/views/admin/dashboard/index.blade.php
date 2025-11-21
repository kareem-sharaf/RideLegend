<x-admin-layout title="Dashboard">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <x-card class="bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_users']) }}</p>
                    <div class="flex items-center mt-2 text-sm">
                        <span class="text-blue-100">Buyers: {{ $stats['total_buyers'] }}</span>
                    </div>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </x-card>

        <!-- Total Revenue -->
        <x-card class="bg-gradient-to-br from-green-500 to-green-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold mt-2">${{ number_format($stats['total_revenue'], 2) }}</p>
                    <div class="flex items-center mt-2 text-sm">
                        <span class="text-green-100">Payments: ${{ number_format($stats['total_payments'], 2) }}</span>
                    </div>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </x-card>

        <!-- Total Orders -->
        <x-card class="bg-gradient-to-br from-purple-500 to-purple-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Orders</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_orders']) }}</p>
                    <div class="flex items-center mt-2 text-sm">
                        <span class="text-purple-100">Pending: {{ $stats['pending_orders'] }}</span>
                    </div>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </x-card>

        <!-- Total Products -->
        <x-card class="bg-gradient-to-br from-orange-500 to-orange-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Total Products</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_products']) }}</p>
                    <div class="flex items-center mt-2 text-sm">
                        <span class="text-orange-100">Pending: {{ $stats['pending_products'] }}</span>
                    </div>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Sales Chart (Last 30 Days) -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Sales (Last 30 Days)</h3>
            <canvas id="salesChart" height="100"></canvas>
        </x-card>

        <!-- Revenue Chart (Last 12 Months) -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Revenue (Last 12 Months)</h3>
            <canvas id="revenueChart" height="100"></canvas>
        </x-card>
    </div>

    <!-- Status Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Orders by Status -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Orders by Status</h3>
            <canvas id="ordersByStatusChart" height="100"></canvas>
        </x-card>

        <!-- Products by Status -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Products by Status</h3>
            <canvas id="productsByStatusChart" height="100"></canvas>
        </x-card>
    </div>

    <!-- Recent Activity Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Orders</h3>
            <div class="space-y-4">
                @forelse($recentOrders as $order)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">#{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-600">{{ $order->buyer->first_name ?? 'N/A' }} - ${{ number_format($order->total, 2) }}</p>
                        </div>
                        <x-badge variant="{{ $order->status === 'delivered' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                            {{ ucfirst($order->status) }}
                        </x-badge>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No recent orders</p>
                @endforelse
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.orders.index') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                    View All Orders →
                </a>
            </div>
        </x-card>

        <!-- Recent Users -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Users</h3>
            <div class="space-y-4">
                @forelse($recentUsers as $user)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        </div>
                        <x-badge variant="info">{{ ucfirst($user->role) }}</x-badge>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No recent users</p>
                @endforelse
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.users.index') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                    View All Users →
                </a>
            </div>
        </x-card>
    </div>

    @push('scripts')
    <script>
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: @json($salesData['labels']),
                datasets: [{
                    label: 'Orders',
                    data: @json($salesData['data']),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: @json($revenueData['labels']),
                datasets: [{
                    label: 'Revenue ($)',
                    data: @json($revenueData['data']),
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Orders by Status Chart
        const ordersStatusCtx = document.getElementById('ordersByStatusChart').getContext('2d');
        new Chart(ordersStatusCtx, {
            type: 'doughnut',
            data: {
                labels: @json($ordersByStatus['labels']),
                datasets: [{
                    data: @json($ordersByStatus['data']),
                    backgroundColor: [
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });

        // Products by Status Chart
        const productsStatusCtx = document.getElementById('productsByStatusChart').getContext('2d');
        new Chart(productsStatusCtx, {
            type: 'pie',
            data: {
                labels: @json($productsByStatus['labels']),
                datasets: [{
                    data: @json($productsByStatus['data']),
                    backgroundColor: [
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });
    </script>
    @endpush
</x-admin-layout>

