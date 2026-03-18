<?php

use Symfony\Component\HttpFoundation\Response;

it('should be able to register a user', function () {
    $response = $this->postJson(route('auth.register'), [
        'first_name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => fake()->email(),
        'password' => fake()->password(),
    ]);

    $response->assertStatus(Response::HTTP_CREATED);
    $this->assertDatabaseCount('users', 1);
});

it('should not be able to register a user with an email that already exists', function () {
    $email = fake()->email();

    $this->postJson(route('auth.register'), [
        'first_name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => $email,
        'password' => fake()->password(),
    ]);

    $response = $this->postJson(route('auth.register'), [
        'first_name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => $email,
        'password' => fake()->password(),
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $this->assertDatabaseCount('users', 1);
});

it('should not be able to register a user with an invalid email', function () {
    $response = $this->postJson(route('auth.register'), [
        'first_name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => 'invalid-email',
        'password' => fake()->password(),
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $this->assertDatabaseCount('users', 0);
});