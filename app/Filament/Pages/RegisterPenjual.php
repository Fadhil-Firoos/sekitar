<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Auth\Register;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class RegisterPenjual extends Register
{
    public $otp_sent = false;
    public $countdown = 0;

    /**
     * Override form untuk menghilangkan field email default
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema($this->getFormSchema())
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * Form schema kustom tanpa email wajib
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255)
                ->autofocus(),

            TextInput::make('email')
                ->label('Email (Opsional)')
                ->email()
                ->maxLength(255)
                ->helperText('Bisa dikosongkan atau diisi untuk keperluan komunikasi'),

            TextInput::make('phone')
                ->label('Nomor WhatsApp')
                ->placeholder('contoh: 6281234567890')
                ->required()
                ->tel()
                ->maxLength(15)
                ->unique(table: User::class, column: 'phone')
                ->live(onBlur: true)
                ->suffixAction(
                    Action::make('sendOtp')
                        ->label(fn () => $this->countdown > 0 ? "Tunggu {$this->countdown}s" : ($this->otp_sent ? "Kirim Ulang" : "Kirim OTP"))
                        ->disabled(fn () => $this->countdown > 0)
                        ->button()
                        ->action(fn (TextInput $component) => $this->sendOtp())
                        ->color('primary')
                        ->size('sm')
                ),

            TextInput::make('otp')
                ->label('Kode OTP')
                ->visible(fn () => $this->otp_sent)
                ->required(fn () => $this->otp_sent)
                ->numeric()
                ->length(6)
                ->helperText('Masukkan 6 digit kode OTP yang dikirim ke WhatsApp Anda')
                ->placeholder('000000'),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->minLength(8)
                ->maxLength(255)
                ->revealable(),

            TextInput::make('password_confirmation')
                ->label('Konfirmasi Password')
                ->password()
                ->same('password')
                ->required()
                ->maxLength(255)
                ->revealable(),
        ];
    }

    /**
     * Kirim OTP ke nomor pengguna via Fazpass
     */
    public function sendOtp()
    {
        try {
            $this->rateLimit(3);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title('Terlalu banyak percobaan')
                ->body("Silakan coba lagi dalam {$exception->secondsUntilAvailable} detik.")
                ->danger()
                ->send();
            return;
        }

        $phone = $this->data['phone'] ?? null;

        if (!$phone) {
            Notification::make()->title('Nomor WhatsApp belum diisi')->danger()->send();
            return;
        }

        try {
            $phone = preg_replace('/\D/', '', $phone);

            if (!str_starts_with($phone, '62')) {
                throw new \Exception('Nomor harus diawali dengan 62 (contoh: 6281234567890)');
            }
            if (strlen($phone) < 10 || strlen($phone) > 15) {
                throw new \Exception('Nomor WhatsApp tidak valid');
            }
            if (User::where('phone', $phone)->exists()) {
                throw new \Exception('Nomor WhatsApp sudah terdaftar');
            }

            if (empty(env('FAZPASS_MERCHANT_KEY')) || empty(env('FAZPASS_GATEWAY_KEY'))) {
                throw new \Exception('Konfigurasi Fazpass belum diatur dengan benar.');
            }

            // Generate OTP
            $generateResponse = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('FAZPASS_MERCHANT_KEY'),
                    'Content-Type' => 'application/json',
                ])->post('https://api.fazpass.com/v1/otp/generate', [
                    'phone' => $phone,
                    'gateway_key' => env('FAZPASS_GATEWAY_KEY'),
                ]);

            if ($generateResponse->failed()) {
                throw new \Exception($generateResponse->json('message') ?? 'Gagal generate OTP.');
            }

            $otpData = $generateResponse->json('data');

            // Send OTP
            $sendResponse = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('FAZPASS_MERCHANT_KEY'),
                    'Content-Type' => 'application/json',
                ])->post('https://api.fazpass.com/v1/otp/send', [
                    'phone' => $phone,
                    'otp' => $otpData['otp'] ?? '',
                    'gateway_key' => env('FAZPASS_GATEWAY_KEY'),
                ]);

            if ($sendResponse->failed()) {
                throw new \Exception('Gagal mengirim OTP ke WhatsApp.');
            }

            Session::put('otp_id', $otpData['id']);
            Session::put('otp_phone', $phone);
            Session::put('otp_expires', now()->addMinutes(5));

            $this->otp_sent = true;
            $this->countdown = 60;

            Notification::make()->title('OTP berhasil dikirim!')->success()->seconds(5)->send();
            $this->dispatch('start-countdown');
        } catch (\Exception $e) {
            Notification::make()->title('Gagal mengirim OTP')->body($e->getMessage())->danger()->send();
        }
    }

    /**
     * Update countdown
     */
    public function updateCountdown()
    {
        if ($this->countdown > 0) $this->countdown--;
    }

    /**
     * Override register method
     */
    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title('Terlalu banyak percobaan')
                ->body("Silakan coba lagi dalam {$exception->secondsUntilAvailable} detik.")
                ->danger()
                ->send();
            return null;
        }

        $data = $this->form->getState();
        $otpId = Session::get('otp_id');
        $phone = Session::get('otp_phone');
        $expires = Session::get('otp_expires');

        if (!$this->otp_sent || !$otpId || !$phone) {
            Notification::make()->title('Silakan kirim OTP terlebih dahulu')->danger()->send();
            return null;
        }

        if (now()->gt($expires)) {
            Notification::make()->title('Kode OTP sudah kadaluarsa')->warning()->send();
            $this->otp_sent = false;
            Session::forget(['otp_id', 'otp_phone', 'otp_expires']);
            return null;
        }

        if (empty($data['otp'])) {
            Notification::make()->title('Kode OTP belum diisi')->danger()->send();
            return null;
        }

        try {
            // Verifikasi OTP
            $verify = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('FAZPASS_MERCHANT_KEY'),
                    'Content-Type' => 'application/json',
                ])->post('https://api.fazpass.com/v1/otp/verify', [
                    'otp_id' => $otpId,
                    'otp' => $data['otp'],
                ]);

            if ($verify->failed() || !($verify->json('status') ?? false)) {
                throw new \Exception($verify->json('message') ?? 'Kode OTP salah atau tidak valid.');
            }

            // Pastikan nomor belum terdaftar
            if (User::where('phone', $data['phone'])->exists()) {
                Notification::make()->title('Nomor WhatsApp sudah terdaftar')->danger()->send();
                return null;
            }

            // Simpan user baru
            $email = $data['email'] ?? $data['phone'] . '@example.com';

            $user = User::create([
                'name' => $data['name'],
                'email' => $email,
                'phone' => $data['phone'],
                'password' => bcrypt($data['password']),
                'role' => 'penjual',
                'is_verified' => true,
            ]);

            Session::forget(['otp_id', 'otp_phone', 'otp_expires']);

            // Login otomatis tanpa $guard
            auth()->login($user);
            session()->regenerate();

            Notification::make()->title('Registrasi berhasil!')->body('Selamat datang di Dashboard Penjual')->success()->send();

            return app(RegistrationResponse::class);
        } catch (\Exception $e) {
            Notification::make()->title('Verifikasi OTP gagal')->body($e->getMessage())->danger()->send();
            return null;
        }
    }

    /**
     * Countdown script
     */
    protected function getFooter(): string
    {
        return <<<'HTML'
<script>
let countdownInterval;

document.addEventListener('livewire:init', () => {
    Livewire.on('start-countdown', () => {
        if (countdownInterval) clearInterval(countdownInterval);
        countdownInterval = setInterval(() => {
            if (window.Livewire) {
                Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).call('updateCountdown');
            }
        }, 1000);
    });
});
</script>
HTML;
    }
}
