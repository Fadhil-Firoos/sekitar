<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class FazzpassOtpService
{
    protected string $gatewayKey;
    protected string $merchantKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->gatewayKey = env('FAZZPASS_GATEWAY_KEY');
        $this->merchantKey = env('FAZZPASS_MERCHANT_KEY');
        $this->baseUrl = 'https://api.fazzpass.com/v1';
    }

    public function sendOtp(string $phone): array
    {
        $response = Http::withHeaders([
            'gateway-key'  => $this->gatewayKey,
            'merchant-key' => $this->merchantKey,
        ])->post($this->baseUrl . '/otp/send', [
            'phone' => $phone,
        ]);

        if ($response->failed()) {
            throw new Exception('Gagal mengirim OTP: ' . $response->body());
        }

        return $response->json();
    }

    public function verifyOtp(string $phone, string $otp): array
    {
        $response = Http::withHeaders([
            'gateway-key'  => $this->gatewayKey,
            'merchant-key' => $this->merchantKey,
        ])->post($this->baseUrl . '/otp/verify', [
            'phone' => $phone,
            'otp'   => $otp,
        ]);

        if ($response->failed()) {
            throw new Exception('Verifikasi OTP gagal: ' . $response->body());
        }

        return $response->json();
    }
}
