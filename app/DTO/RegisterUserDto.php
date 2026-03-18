<?php

namespace App\DTO;

use App\Contracts\DtoInterface;

class RegisterUserDto implements DtoInterface
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $password,
        public bool $is_admin,
    ) {
    }

    public static function fromArray(array $data): DtoInterface
    {
        return new self(
            first_name: data_get($data, 'first_name'),
            last_name: data_get($data, 'last_name'),
            email: data_get($data, 'email'),
            password: data_get($data, 'password'),
            is_admin: data_get($data, 'is_admin', false),
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}