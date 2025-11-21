@extends('layouts.main')

@section('title', 'My Orders')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">My Orders</h1>

    @if(empty($orders))
        <div class="text-center py-12">
            <p class="text-gray-600 mb-4">You have no orders yet</p>
            <a href="{{ route('products.index') }}" class="btn-primary">Start Shopping</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold">Order #{{ $order->getOrderNumber()->getValue() }}</h3>
                        <p class="text-sm text-gray-500">Placed on {{ $order->getPlacedAt()?->format('M d, Y') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($order->getStatus()->getValue()) }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600">Total: <span class="font-semibold">${{ number_format($order->getTotal()->getAmount(), 2) }}</span></p>
                    </div>
                    <a href="{{ route('orders.show', $order->getId()) }}" class="btn-secondary">View Details</a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

