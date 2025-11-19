<x-auth-layout title="Verify OTP">
    <x-card>
        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-6">
            @csrf

            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Verify OTP</h2>
                <p class="text-gray-600">Enter the OTP code sent to your {{ session('otp_channel', 'email') }}</p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <x-form-input
                label="OTP Code"
                name="otp"
                type="text"
                placeholder="000000"
                maxlength="6"
                required
            />

            <input type="hidden" name="identifier" value="{{ session('otp_identifier') }}">

            <div>
                <x-button type="submit" variant="primary" class="w-full">
                    Verify OTP
                </x-button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Didn't receive the code?
                    <a href="{{ route('otp.send') }}" class="text-primary-600 hover:text-primary-800 font-medium">
                        Resend OTP
                    </a>
                </p>
            </div>
        </form>
    </x-card>
</x-auth-layout>

