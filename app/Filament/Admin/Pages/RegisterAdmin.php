<?php

namespace App\Filament\Admin\Pages;

use App\Models\User;
use Filament\Pages\Auth\Register;
use Illuminate\Support\Facades\Hash;

class RegisterAdmin extends Register
{
    protected function handleRegistration(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'admin',
        ]);
    }
}
