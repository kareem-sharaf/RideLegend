<x-admin-layout title="Shipping Management">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Shipping Management</h2>
    </div>

    <!-- Filters -->
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.shipping.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by tracking number..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="label_created" {{ request('status') === 'label_created' ? 'selected' : '' }}>Label Created</option>
                    <option value="picked_up" {{ request('status') === 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                    <option value="in_transit" {{ request('status') === 'in_transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="out_for_delivery" {{ request('status') === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="exception" {{ request('status') === 'exception' ? 'selected' : '' }}>Exception</option>
                </select>
            </div>
            <div>
                <select name="carrier" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <option value="">All Carriers</option>
                    <option value="DHL" {{ request('carrier') === 'DHL' ? 'selected' : '' }}>DHL</option>
                    <option value="Aramex" {{ request('carrier') === 'Aramex' ? 'selected' : '' }}>Aramex</option>
                    <option value="Local Courier" {{ request('carrier') === 'Local Courier' ? 'selected' : '' }}>Local Courier</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'carrier']))
                    <a href="{{ route('admin.shipping.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Shipping Table -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Carrier</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tracking Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($shippings as $shipping)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <a href="{{ route('admin.orders.show', $shipping->order_id) }}" class="text-primary-600 hover:underline">
                                    Order #{{ $shipping->order->order_number ?? $shipping->order_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $shipping->carrier }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-mono">
                                {{ $shipping->tracking_number ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($shipping->status === 'delivered')
                                    <x-badge variant="success">Delivered</x-badge>
                                @elseif($shipping->status === 'exception')
                                    <x-badge variant="danger">Exception</x-badge>
                                @else
                                    <x-badge variant="info">{{ ucfirst(str_replace('_', ' ', $shipping->status)) }}</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                ${{ number_format($shipping->cost, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $shipping->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.shipping.show', $shipping->id) }}" 
                                       class="text-primary-600 hover:text-primary-900">View</a>
                                    @if($shipping->tracking_number)
                                        <a href="{{ route('shipping.track', $shipping->tracking_number) }}" 
                                           class="text-blue-600 hover:text-blue-900">Track</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No shipping records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $shippings->links() }}</div>
    </x-card>
</x-admin-layout>

