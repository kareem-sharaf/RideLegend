@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf

                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address Line 1</label>
                            <input type="text" name="shipping_address_line1" required class="mt-1 block w-full border rounded-md px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address Line 2</label>
                            <input type="text" name="shipping_address_line2" class="mt-1 block w-full border rounded-md px-3 py-2">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="shipping_city" required class="mt-1 block w-full border rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">State</label>
                                <input type="text" name="shipping_state" required class="mt-1 block w-full border rounded-md px-3 py-2">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Postal Code</label>
                                <input type="text" name="shipping_postal_code" required class="mt-1 block w-full border rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Country</label>
                                <input type="text" name="shipping_country" required class="mt-1 block w-full border rounded-md px-3 py-2">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                    
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="stripe" checked class="mr-2">
                            <span>Credit Card (Stripe)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="paypal" class="mr-2">
                            <span>PayPal</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="local_gateway" class="mr-2">
                            <span>Local Gateway</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="mt-6 w-full btn-primary">Complete Order</button>
            </form>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>${{ number_format($totals['subtotal'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax</span>
                        <span>${{ number_format($totals['tax'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span>${{ number_format($totals['shipping_cost'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Discount</span>
                        <span>-${{ number_format($totals['discount'] ?? 0, 2) }}</span>
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span>${{ number_format($totals['total'] ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

