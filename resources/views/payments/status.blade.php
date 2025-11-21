@extends('layouts.main')

@section('title', 'Payment Status')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Payment Status</h1>

    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        <div class="text-center mb-6">
            <div class="inline-block p-4 rounded-full mb-4
                @if($payment->getStatus()->isCompleted()) bg-green-100 text-green-600
                @elseif($payment->getStatus()->isFailed()) bg-red-100 text-red-600
                @else bg-yellow-100 text-yellow-600
                @endif">
                @if($payment->getStatus()->isCompleted())
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                @elseif($payment->getStatus()->isFailed())
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                @else
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @endif
            </div>
            
            <h2 class="text-2xl font-semibold mb-2">
                @if($payment->getStatus()->isCompleted())
                    Payment Successful
                @elseif($payment->getStatus()->isFailed())
                    Payment Failed
                @else
                    Payment Processing
                @endif
            </h2>
            
            <p class="text-gray-600">
                Transaction ID: {{ $payment->getTransactionId() ?? 'N/A' }}
            </p>
        </div>

        <div class="space-y-4">
            <div class="flex justify-between">
                <span class="text-gray-600">Amount</span>
                <span class="font-semibold">${{ number_format($payment->getAmount()->getAmount(), 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Payment Method</span>
                <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $payment->getPaymentMethod()->getValue())) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Status</span>
                <span class="font-semibold">{{ ucfirst($payment->getStatus()->getValue()) }}</span>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('orders.index') }}" class="btn-primary">View Orders</a>
        </div>
    </div>
</div>
@endsection

