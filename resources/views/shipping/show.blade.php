<x-dashboard-layout title="Shipping Details">
    <div class="max-w-4xl mx-auto">
        <x-card>
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Shipping Information</h1>

            <div class="space-y-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Tracking Number</h2>
                    <p class="text-gray-900">{{ $shipping->getTrackingNumber() }}</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Status</h2>
                    <x-badge variant="info">{{ ucfirst($shipping->getStatus()->value) }}</x-badge>
                </div>

                @if($shipping->getCarrier())
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Carrier</h2>
                        <p class="text-gray-900">{{ $shipping->getCarrier() }}</p>
                    </div>
                @endif

                @if($shipping->getEstimatedDeliveryDate())
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Estimated Delivery</h2>
                        <p class="text-gray-900">{{ $shipping->getEstimatedDeliveryDate()->format('Y-m-d') }}</p>
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('shipping.track', $shipping->getTrackingNumber()) }}" class="btn-primary">
                        Track Shipment
                    </a>
                </div>
            </div>
        </x-card>
    </div>
</x-dashboard-layout>

