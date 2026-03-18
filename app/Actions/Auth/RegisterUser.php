<?php

namespace App\Actions\Auth;

use App\DTO\RegisterUserDto;
use App\Models\User;

class RegisterUser
{
    public function execute(RegisterUserDto $data): void
    {
        User::query()->create($data->toArray());
    }
}