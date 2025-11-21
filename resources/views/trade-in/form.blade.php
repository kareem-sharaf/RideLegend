@extends('layouts.main')

@section('title', 'Trade-In Request')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Trade-In Your Bike</h1>

    <div class="max-w-2xl mx-auto">
        <form action="{{ route('trade-in.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand *</label>
                    <input type="text" name="brand" required class="w-full border rounded-md px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Model *</label>
                    <input type="text" name="model" required class="w-full border rounded-md px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                    <input type="number" name="year" min="1900" max="{{ date('Y') }}" class="w-full border rounded-md px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                    <select name="condition" class="w-full border rounded-md px-3 py-2">
                        <option value="">Select condition</option>
                        <option value="excellent">Excellent</option>
                        <option value="good">Good</option>
                        <option value="fair">Fair</option>
                        <option value="poor">Poor</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full border rounded-md px-3 py-2"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Images (max 10)</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full border rounded-md px-3 py-2">
                </div>

                <button type="submit" class="w-full btn-primary">Submit Trade-In Request</button>
            </div>
        </form>
    </div>
</div>
@endsection

