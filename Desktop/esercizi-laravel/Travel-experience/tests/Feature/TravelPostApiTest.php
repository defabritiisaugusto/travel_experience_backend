<?php

use App\Models\TravelPost;
use App\Models\User;

test('guests can list travel posts', function () {
    TravelPost::factory()->count(2)->create();

    $this->getJson('/api/travel-posts')
        ->assertOk()
        ->assertJsonCount(2, 'data');
});

test('an authenticated user can create a travel post', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this
        ->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/travel-posts', [
            'title' => 'Weekend in Rome',
            'location' => 'Rome',
            'country' => 'Italy',
            'description' => 'A great city break with food, art, and lots of walking.',
        ]);

    $response
        ->assertCreated()
        ->assertJsonPath('data.user_id', $user->id);

    $this->assertDatabaseHas('travel_posts', [
        'title' => 'Weekend in Rome',
        'user_id' => $user->id,
    ]);
});

test('a user cannot update another users post', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();
    $post = TravelPost::factory()->for($owner)->create();
    $token = $intruder->createToken('test-token')->plainTextToken;

    $this
        ->withHeader('Authorization', 'Bearer '.$token)
        ->putJson("/api/travel-posts/{$post->id}", [
            'title' => 'Changed title',
            'location' => $post->location,
            'country' => $post->country,
            'description' => $post->description,
        ])
        ->assertForbidden();
});

test('user profiles include authored posts', function () {
    $user = User::factory()->create();
    TravelPost::factory()->count(2)->for($user)->create();

    $this->getJson("/api/users/{$user->id}")
        ->assertOk()
        ->assertJsonCount(2, 'data.posts');
});
