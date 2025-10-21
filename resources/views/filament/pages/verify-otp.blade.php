{{-- resources/views/filament/pages/verify-otp.blade.php --}}
<x-filament::page>
    <div class="space-y-4">
        <h2 class="text-lg font-semibold">Verifikasi OTP</h2>

        <form wire:submit.prevent="verifyOtp" class="space-y-3">
            <x-filament::input
                type="text"
                wire:model.defer="otp"
                placeholder="Masukkan kode OTP"
            />

            <x-filament::button type="submit" color="primary">
                Verifikasi
            </x-filament::button>
        </form>

        <div class="text-sm text-gray-500">
            Tidak menerima kode? <a href="#" wire:click.prevent="resendOtp" class="text-primary-600">Kirim ulang</a>
            <span wire:poll.1000ms="updateCountdown">
                (Kirim ulang dalam {{ $countdown }} detik)
            </span>
        </div>
    </div>
</x-filament::page>
