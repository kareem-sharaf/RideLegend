@extends('layouts.main')

@section('title', 'Order Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Order #{{ $order->getOrderNumber()->getValue() }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Order Items</h2>
                
                <div class="space-y-4">
                    @foreach($order->getItems() as $item)
                    <div class="flex justify-between items-center border-b pb-4">
                        <div>
                            <p class="font-medium">Product #{{ $item->getProductId() }}</p>
                            <p class="text-sm text-gray-500">Quantity: {{ $item->getQuantity() }}</p>
                        </div>
                        <p class="font-semibold">${{ number_format($item->getTotalPrice()->getAmount(), 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->getSubtotal()->getAmount(), 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax</span>
                        <span>${{ number_format($order->getTax()->getAmount(), 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span>${{ number_format($order->getShippingCost()->getAmount(), 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Discount</span>
                        <span>-${{ number_format($order->getDiscount()->getAmount(), 2) }}</span>
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span>${{ number_format($order->getTotal()->getAmount(), 2) }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-sm text-gray-500 mb-2">Status</p>
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($order->getStatus()->getValue()) }}
                    </span>
                </div>

                @if($order->getStatus()->isPending() || $order->getStatus()->isConfirmed())
                <form action="{{ route('orders.cancel', $order->getId()) }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="w-full btn-secondary">Cancel Order</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

