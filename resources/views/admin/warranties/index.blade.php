<x-admin-layout title="Warranties Management">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Warranties Management</h2>
    </div>

    <!-- Filters -->
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.warranties.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <option value="">All Types</option>
                    <option value="free" {{ request('type') === 'free' ? 'selected' : '' }}>Free</option>
                    <option value="paid" {{ request('type') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="extended" {{ request('type') === 'extended' ? 'selected' : '' }}>Extended</option>
                </select>
            </div>
            <div>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Filter
                </button>
                @if(request()->hasAny(['status', 'type', 'date_from']))
                    <a href="{{ route('admin.warranties.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Warranties Table -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expires</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($warranties as $warranty)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <a href="{{ route('admin.orders.show', $warranty->order_id) }}" class="text-primary-600 hover:underline">
                                    Order #{{ $warranty->order->order_number ?? $warranty->order_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $warranty->product->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ ucfirst($warranty->type) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $warranty->duration_months }} months
                            </td>
                            <td class="px-6 py-4">
                                @if($warranty->status === 'active')
                                    <x-badge variant="success">Active</x-badge>
                                @elseif($warranty->status === 'expired')
                                    <x-badge variant="warning">Expired</x-badge>
                                @else
                                    <x-badge variant="danger">Cancelled</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $warranty->expires_at ? $warranty->expires_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('admin.warranties.show', $warranty->id) }}" 
                                   class="text-primary-600 hover:text-primary-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No warranties found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $warranties->links() }}</div>
    </x-card>
</x-admin-layout>

