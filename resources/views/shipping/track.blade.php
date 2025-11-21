@extends('layouts.main')

@section('title', 'Track Shipment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Track Shipment</h1>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-xl font-semibold">Tracking Number</h2>
                    <p class="text-2xl font-bold text-blue-600">{{ $shipping->getTrackingNumber() }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ ucfirst(str_replace('_', ' ', $shipping->getStatus()->getValue())) }}
                </span>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Carrier</span>
                    <span class="font-semibold">{{ $shipping->getCarrier() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Service Type</span>
                    <span class="font-semibold">{{ $shipping->getServiceType() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Shipping Cost</span>
                    <span class="font-semibold">${{ number_format($shipping->getCost()->getAmount(), 2) }}</span>
                </div>
            </div>
        </div>

        @if(isset($trackingInfo['events']))
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Tracking History</h2>
            
            <div class="space-y-4">
                @foreach($trackingInfo['events'] as $event)
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-3 h-3 rounded-full bg-blue-500 mt-2"></div>
                    <div class="ml-4">
                        <p class="font-medium">{{ $event['description'] ?? 'Status update' }}</p>
                        <p class="text-sm text-gray-500">{{ $event['location'] ?? '' }}</p>
                        <p class="text-xs text-gray-400">{{ $event['timestamp'] ?? '' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

