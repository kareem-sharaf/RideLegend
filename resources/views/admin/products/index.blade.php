<x-admin-layout title="Products Management">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Products Management</h2>
        <div class="flex gap-2">
            <form method="GET" action="{{ route('admin.products.export') }}" class="inline">
                @foreach(request()->except(['format']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <input type="hidden" name="format" value="csv">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Export CSV
                </button>
            </form>
            <form method="GET" action="{{ route('admin.products.export') }}" class="inline">
                @foreach(request()->except(['format']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <input type="hidden" name="format" value="pdf">
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Export PDF
                </button>
            </form>
        </div>
    </div>

    <!-- Filters -->
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search products..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <input type="number" name="min_price" value="{{ request('min_price') }}" 
                       placeholder="Min Price" step="0.01"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                       placeholder="Max Price" step="0.01"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'min_price', 'max_price']))
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Bulk Actions -->
    <x-card class="mb-6">
        <form id="bulkActionForm" method="POST" action="{{ route('admin.products.bulk-action') }}">
            @csrf
            <div class="flex items-center gap-4">
                <select name="action" id="bulkAction" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Bulk Actions</option>
                    <option value="approve">Approve Selected</option>
                    <option value="reject">Reject Selected</option>
                    <option value="delete">Delete Selected</option>
                </select>
                <button type="submit" id="bulkActionBtn" disabled class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    Apply
                </button>
                <span id="selectedCount" class="text-sm text-gray-600">0 selected</span>
            </div>
            <input type="hidden" name="ids" id="bulkActionIds">
        </form>
    </x-card>

    <!-- Products Table -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <a href="{{ route('admin.products.index', array_merge(request()->all(), ['sort_by' => 'title', 'sort_direction' => request('sort_by') === 'title' && request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                Product
                                @if(request('sort_by') === 'title')
                                    <span>{{ request('sort_direction') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Seller</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <a href="{{ route('admin.products.index', array_merge(request()->all(), ['sort_by' => 'price', 'sort_direction' => request('sort_by') === 'price' && request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                Price
                                @if(request('sort_by') === 'price')
                                    <span>{{ request('sort_direction') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <a href="{{ route('admin.products.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_direction' => request('sort_by') === 'created_at' && request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                Created
                                @if(request('sort_by') === 'created_at' || !request('sort_by'))
                                    <span>{{ (request('sort_direction') ?? 'desc') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="product-checkbox rounded border-gray-300" value="{{ $product->id }}">
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $product->title }}</div>
                                <div class="text-sm text-gray-500">{{ $product->brand }} {{ $product->model }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $product->seller->first_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($product->status === 'active')
                                    <x-badge variant="success">Active</x-badge>
                                @elseif($product->status === 'rejected')
                                    <x-badge variant="danger">Rejected</x-badge>
                                @else
                                    <x-badge variant="warning">Pending</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $product->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.show', $product->id) }}" 
                                       class="text-primary-600 hover:text-primary-900">View</a>
                                    @if($product->status === 'pending')
                                        <form method="POST" action="{{ route('admin.products.approve', $product->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.products.reject', $product->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No products found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    </x-card>

    <script>
        // Bulk selection
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const bulkActionBtn = document.getElementById('bulkActionBtn');
        const bulkAction = document.getElementById('bulkAction');
        const selectedCount = document.getElementById('selectedCount');
        const bulkActionIds = document.getElementById('bulkActionIds');

        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkActionState();
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkActionState);
        });

        function updateBulkActionState() {
            const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
            selectedCount.textContent = `${selected.length} selected`;
            bulkActionIds.value = JSON.stringify(selected);
            bulkActionBtn.disabled = selected.length === 0 || !bulkAction.value;
        }

        bulkAction.addEventListener('change', function() {
            bulkActionBtn.disabled = !this.value || JSON.parse(bulkActionIds.value || '[]').length === 0;
        });

        document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
            const ids = JSON.parse(bulkActionIds.value || '[]');
            if (ids.length === 0 || !bulkAction.value) {
                e.preventDefault();
                alert('Please select items and an action');
                return false;
            }
            if (bulkAction.value === 'delete' && !confirm(`Are you sure you want to delete ${ids.length} product(s)?`)) {
                e.preventDefault();
                return false;
            }
        });
    </script>
</x-admin-layout>
