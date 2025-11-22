<x-admin-layout title="Payments Management">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Payments Management</h2>
    </div>

    <!-- Filters -->
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by transaction ID..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div>
                <select name="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <option value="">All Methods</option>
                    <option value="stripe" {{ request('payment_method') === 'stripe' ? 'selected' : '' }}>Stripe</option>
                    <option value="paypal" {{ request('payment_method') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                    <option value="local_gateway" {{ request('payment_method') === 'local_gateway' ? 'selected' : '' }}>Local Gateway</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'payment_method']))
                    <a href="{{ route('admin.payments.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Payments Table -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $payment->transaction_id ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $payment->user->email ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <a href="{{ route('admin.orders.show', $payment->order_id) }}" class="text-primary-600 hover:underline">
                                    #{{ $payment->order->order_number ?? $payment->order_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                ${{ number_format($payment->amount, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($payment->status === 'completed')
                                    <x-badge variant="success">Completed</x-badge>
                                @elseif($payment->status === 'failed')
                                    <x-badge variant="danger">Failed</x-badge>
                                @elseif($payment->status === 'refunded')
                                    <x-badge variant="warning">Refunded</x-badge>
                                @else
                                    <x-badge variant="info">{{ ucfirst($payment->status) }}</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $payment->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" 
                                       class="text-primary-600 hover:text-primary-900">View</a>
                                    @if($payment->status === 'completed')
                                        <button onclick="showRefundModal({{ $payment->id }})" 
                                                class="text-orange-600 hover:text-orange-900">Refund</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No payments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $payments->links() }}</div>
    </x-card>

    <!-- Refund Modal -->
    <div id="refundModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Refund Payment</h3>
            <form id="refundForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount (leave empty for full refund)</label>
                    <input type="number" name="amount" step="0.01" min="0.01" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                    <textarea name="reason" rows="3" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                        Process Refund
                    </button>
                    <button type="button" onclick="closeRefundModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showRefundModal(paymentId) {
            document.getElementById('refundForm').action = `/admin/payments/${paymentId}/refund`;
            document.getElementById('refundModal').classList.remove('hidden');
        }

        function closeRefundModal() {
            document.getElementById('refundModal').classList.add('hidden');
        }
    </script>
</x-admin-layout>

