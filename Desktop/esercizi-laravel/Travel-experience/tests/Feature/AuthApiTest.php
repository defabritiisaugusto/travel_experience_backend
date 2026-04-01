<?php

use App\Models\User;

test('a user can register and receive an api token', function () {
    $response = $this->postJson('/api/users', [
        'name' => 'Augusto',
        'email' => 'augusto@example.com',
        'password' => 'password123',
    ]);

    $response
        ->assertCreated()
        ->assertJsonStructure([
            'message',
            'token',
            'data' => ['id', 'name', 'email', 'posts_count', 'comments_count', 'likes_count'],
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'augusto@example.com',
    ]);
});

test('a user can login and receive a new token', function () {
    User::factory()->create([
        'email' => 'augusto@example.com',
        'password' => 'password123',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'augusto@example.com',
        'password' => 'password123',
    ]);

    $response
        ->assertOk()
        ->assertJsonStructure([
            'message',
            'token',
            'data' => ['id', 'name', 'email', 'posts_count', 'comments_count', 'likes_count'],
        ]);
});

test('an authenticated user can fetch their own profile', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this
        ->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/me');

    $response
        ->assertOk()
        ->assertJsonPath('data.id', $user->id);
});

test('logout revokes the current token', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $this
        ->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/logout')
        ->assertNoContent();

    expect($user->fresh()->tokens()->count())->toBe(0);
});
