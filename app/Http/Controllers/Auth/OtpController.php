<?php

namespace App\Http\Controllers\Auth;

use App\Application\Auth\Actions\SendOtpAction;
use App\Application\Auth\Actions\VerifyOtpAction;
use App\Application\Auth\DTOs\SendOtpDTO;
use App\Application\Auth\DTOs\VerifyOtpDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use Illuminate\Http\JsonResponse;

class OtpController extends Controller
{
    public function __construct(
        private SendOtpAction $sendOtpAction,
        private VerifyOtpAction $verifyOtpAction
    ) {}

    public function showVerifyForm()
    {
        return view('auth.otp-verify');
    }

    public function send(SendOtpRequest $request)
    {
        $dto = SendOtpDTO::fromArray($request->validated());
        $this->sendOtpAction->execute($dto);

        session(['otp_identifier' => $dto->identifier, 'otp_channel' => $dto->channel]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'OTP sent successfully',
            ]);
        }

        return redirect()->route('otp.verify.form')->with('success', 'OTP sent successfully!');
    }
    {
        $dto = SendOtpDTO::fromArray($request->validated());
        $this->sendOtpAction->execute($dto);

        return response()->json([
            'message' => 'OTP sent successfully',
        ]);
    }

    public function verify(VerifyOtpRequest $request)
    {
        $dto = VerifyOtpDTO::fromArray($request->validated());
        $this->verifyOtpAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'OTP verified successfully',
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'OTP verified successfully!');
    }
}

