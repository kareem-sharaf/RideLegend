<x-dashboard-layout title="Settings">
    <div class="max-w-2xl mx-auto">
        <x-card>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Change Password</h2>

            <form method="POST" action="{{ route('profile.password.change') }}" class="space-y-6">
                @csrf

                <x-form-input
                    label="Current Password"
                    name="current_password"
                    type="password"
                    required
                />

                <x-form-input
                    label="New Password"
                    name="new_password"
                    type="password"
                    required
                />

                <x-form-input
                    label="Confirm New Password"
                    name="new_password_confirmation"
                    type="password"
                    required
                />

                <div class="flex space-x-4">
                    <x-button type="submit" variant="primary">Change Password</x-button>
                    <x-button href="{{ route('profile.show') }}" variant="secondary">Cancel</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>

