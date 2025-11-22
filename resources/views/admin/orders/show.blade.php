<x-admin-layout title="Order Details">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Order #{{ $order->order_number }}</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Back to List
            </a>
            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Download Invoice
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $item->product->title ?? 'Product #' . $item->product_id }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            <!-- Payment Information -->
            @if($order->payments->count() > 0)
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Payment Information</h3>
                <div class="space-y-3">
                    @foreach($order->payments as $payment)
                    <div class="flex justify-between items-center border-b pb-3">
                        <div>
                            <p class="text-sm font-medium">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->transaction_id ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold">${{ number_format($payment->amount, 2) }}</p>
                            <x-badge variant="{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($payment->status) }}
                            </x-badge>
                        </div>
                    </div>
                    @endforeach
                </div>
            </x-card>
            @endif

            <!-- Shipping Information -->
            @if($order->shipping)
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Shipping Information</h3>
                <div class="space-y-2">
                    <p class="text-sm">
                        <span class="font-medium">Carrier:</span> {{ $order->shipping->carrier }}
                    </p>
                    <p class="text-sm">
                        <span class="font-medium">Tracking Number:</span> 
                        {{ $order->shipping->tracking_number ?? 'N/A' }}
                    </p>
                    <p class="text-sm">
                        <span class="font-medium">Status:</span>
                        <x-badge variant="info">{{ ucfirst(str_replace('_', ' ', $order->shipping->status)) }}</x-badge>
                    </p>
                </div>
            </x-card>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-semibold">${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold">${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Discount</span>
                        <span class="font-semibold">-${{ number_format($order->discount, 2) }}</span>
                    </div>
                    <div class="border-t pt-2 mt-2">
                        <div class="flex justify-between">
                            <span class="font-semibold">Total</span>
                            <span class="font-bold text-lg">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Buyer Information -->
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Buyer Information</h3>
                <div class="space-y-2">
                    <p class="text-sm">
                        <span class="font-medium">Name:</span>
                        {{ $order->buyer->first_name }} {{ $order->buyer->last_name }}
                    </p>
                    <p class="text-sm">
                        <span class="font-medium">Email:</span>
                        {{ $order->buyer->email }}
                    </p>
                </div>
            </x-card>

            <!-- Status Update -->
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                    @csrf
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-3">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                        Update Status
                    </button>
                </form>
            </x-card>
        </div>
    </div>
</x-admin-layout>

