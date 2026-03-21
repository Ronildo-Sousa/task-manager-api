<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

it('should be able to login with correct credentials', function () {
    $user = User::factory()->create();

    $response = $this->postJson(route('auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);

    $this->assertAuthenticatedAs($user);
});

it('should not be able to login with incorrect credentials', function () {
    $user = User::factory()->create();

    $response = $this->postJson(route('auth.login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    $this->assertGuest();
});

it('should be able to logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->postJson(route('auth.logout'));

    $response->assertStatus(Response::HTTP_OK);

    $this->assertGuest();
});