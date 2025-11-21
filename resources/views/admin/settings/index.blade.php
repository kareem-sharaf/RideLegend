<x-admin-layout title="Settings">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Platform Settings</h2>
        <p class="text-gray-600 mt-1">Manage commission rates and platform fees</p>
    </div>

    <x-card>
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Commission Fees</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Commission Rate (%)
                            </label>
                            <input type="number" name="commission_rate" 
                                   value="{{ old('commission_rate', $settings['commission_rate']) }}" 
                                   step="0.1" min="0" max="100"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                   required>
                            <p class="mt-1 text-sm text-gray-500">Total commission rate for the platform</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Seller Commission Rate (%)
                            </label>
                            <input type="number" name="seller_commission_rate" 
                                   value="{{ old('seller_commission_rate', $settings['seller_commission_rate']) }}" 
                                   step="0.1" min="0" max="100"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                   required>
                            <p class="mt-1 text-sm text-gray-500">Commission rate charged to sellers</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Platform Fee (%)
                            </label>
                            <input type="number" name="platform_fee" 
                                   value="{{ old('platform_fee', $settings['platform_fee']) }}" 
                                   step="0.1" min="0" max="100"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                   required>
                            <p class="mt-1 text-sm text-gray-500">Additional platform service fee</p>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Service Fees</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Inspection Fee ($)
                            </label>
                            <input type="number" name="inspection_fee" 
                                   value="{{ old('inspection_fee', $settings['inspection_fee']) }}" 
                                   step="0.01" min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                   required>
                            <p class="mt-1 text-sm text-gray-500">Fee charged for product inspection</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Shipping Base Cost ($)
                            </label>
                            <input type="number" name="shipping_base_cost" 
                                   value="{{ old('shipping_base_cost', $settings['shipping_base_cost']) }}" 
                                   step="0.01" min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                   required>
                            <p class="mt-1 text-sm text-gray-500">Base shipping cost</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Save Settings
                </button>
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancel
                </a>
            </div>
        </form>
    </x-card>
</x-admin-layout>

