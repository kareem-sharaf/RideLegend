<x-admin-layout title="Trade-ins Management">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Trade-ins Management</h2>
    </div>

    <!-- Filters -->
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.trade-ins.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by buyer..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="valuated" {{ request('status') === 'valuated' ? 'selected' : '' }}>Valuated</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
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
                @if(request()->hasAny(['search', 'status', 'date_from']))
                    <a href="{{ route('admin.trade-ins.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Trade-ins Table -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buyer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bike Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valuation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tradeIns as $tradeIn)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $tradeIn->buyer->first_name ?? 'N/A' }} {{ $tradeIn->buyer->last_name ?? '' }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $tradeIn->buyer->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($tradeIn->request)
                                    {{ $tradeIn->request->brand ?? 'N/A' }} {{ $tradeIn->request->model ?? '' }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                @if($tradeIn->valuation)
                                    ${{ number_format($tradeIn->valuation->amount, 2) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($tradeIn->status === 'approved')
                                    <x-badge variant="success">Approved</x-badge>
                                @elseif($tradeIn->status === 'rejected')
                                    <x-badge variant="danger">Rejected</x-badge>
                                @elseif($tradeIn->status === 'valuated')
                                    <x-badge variant="info">Valuated</x-badge>
                                @else
                                    <x-badge variant="warning">{{ ucfirst($tradeIn->status) }}</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $tradeIn->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.trade-ins.show', $tradeIn->id) }}" 
                                       class="text-primary-600 hover:text-primary-900">View</a>
                                    @if($tradeIn->status === 'valuated')
                                        <form method="POST" action="{{ route('admin.trade-ins.approve', $tradeIn->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                        </form>
                                        <button onclick="showRejectModal({{ $tradeIn->id }})" class="text-red-600 hover:text-red-900">Reject</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No trade-ins found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $tradeIns->links() }}</div>
    </x-card>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Reject Trade-in</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason *</label>
                    <textarea name="reason" rows="3" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Reject
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showRejectModal(tradeInId) {
            document.getElementById('rejectForm').action = `/admin/trade-ins/${tradeInId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-admin-layout>

