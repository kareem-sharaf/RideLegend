<x-dashboard-layout title="Edit Profile">
    <div class="max-w-2xl mx-auto">
        <x-card>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Profile</h2>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <x-form-input
                        label="First Name"
                        name="first_name"
                        type="text"
                        value="{{ old('first_name', auth()->user()->first_name) }}"
                    />

                    <x-form-input
                        label="Last Name"
                        name="last_name"
                        type="text"
                        value="{{ old('last_name', auth()->user()->last_name) }}"
                    />
                </div>

                <x-form-input
                    label="Phone"
                    name="phone"
                    type="tel"
                    value="{{ old('phone', auth()->user()->phone) }}"
                />

                <div class="flex space-x-4">
                    <x-button type="submit" variant="primary">Update Profile</x-button>
                    <x-button href="{{ route('profile.show') }}" variant="secondary">Cancel</x-button>
                </div>
            </form>
        </x-card>

        <x-card class="mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Avatar</h3>
            <form method="POST" action="{{ route('profile.avatar.upload') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                </div>
                <x-button type="submit" variant="primary">Upload Avatar</x-button>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>

