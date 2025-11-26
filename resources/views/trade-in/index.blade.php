@extends('layouts.main')

@section('title', 'My Trade-Ins')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">My Trade-Ins</h1>
        <a href="{{ route('trade-in.create') }}" class="btn-primary">Submit New Trade-In</a>
    </div>

    @if(empty($tradeIns))
        <div class="text-center py-12">
            <p class="text-gray-600 mb-4">You have no trade-in requests yet</p>
            <a href="{{ route('trade-in.create') }}" class="btn-primary">Submit Trade-In Request</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($tradeIns as $tradeIn)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold">Trade-In #{{ $tradeIn->getId() }}</h3>
                        <p class="text-sm text-gray-500">
                            Requested on {{ $tradeIn->getRequestedAt()?->format('M d, Y') }}
                        </p>
                    </div>
                    @php
                        $status = $tradeIn->getStatus()->getValue();
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'valuated' => 'bg-blue-100 text-blue-800',
                            'approved' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'completed' => 'bg-gray-100 text-gray-800',
                        ];
                        $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                        {{ ucfirst($status) }}
                    </span>
                </div>
                
                @if($tradeIn->getRejectionReason())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-md">
                        <p class="text-sm text-red-800">
                            <strong>Rejection Reason:</strong> {{ $tradeIn->getRejectionReason() }}
                        </p>
                    </div>
                @endif
                
                <div class="flex justify-between items-center">
                    <div>
                        @if($tradeIn->getApprovedAt())
                            <p class="text-sm text-gray-600">Approved on {{ $tradeIn->getApprovedAt()?->format('M d, Y') }}</p>
                        @endif
                    </div>
                    <a href="{{ route('trade-in.show', $tradeIn->getId()) }}" class="btn-secondary">View Details</a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

