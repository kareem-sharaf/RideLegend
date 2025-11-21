@extends('layouts.main')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

    @if(empty($cartItems))
        <div class="text-center py-12">
            <p class="text-gray-600 mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="btn-primary">Continue Shopping</a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Product #{{ $item->getProductId() }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            ${{ number_format($item->getUnitPrice()?->getAmount() ?? 0, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <input type="number" value="{{ $item->getQuantity() }}" min="1" class="w-20 px-2 py-1 border rounded">
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            ${{ number_format(($item->getUnitPrice()?->getAmount() ?? 0) * $item->getQuantity(), 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-red-600 hover:text-red-800">Remove</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('checkout.index') }}" class="btn-primary">Proceed to Checkout</a>
        </div>
    @endif
</div>
@endsection

