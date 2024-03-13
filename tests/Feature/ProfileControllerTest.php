<?php

namespace Tests\Feature;

use Database\Factories\ProfileFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[TestDox('When user is authenticated, given valid data, should create profile')]
    public function testShouldCreateProfile(): void
    {
        $user = UserFactory::new()->createOne(['id' => 1]);

        $response = $this->actingAs($user, 'sanctum')->postJson('api/profiles', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'image_url' => 'https://www.google.fr',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'image_url' => 'https://www.google.fr',
        ]);
    }

    #[TestDox('When user is authenticated, given missing data, should return validation error')]
    public function testShouldNotCreateProfileInvalidData(): void
    {
        $user = UserFactory::new()->createOne(['id' => 1]);

        $response = $this->actingAs($user, 'sanctum')->postJson('api/profiles', [
            'first_name' => 'John',
            'image_url' => 'https://www.google.fr',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('last_name');
    }

    #[TestDox('When user is not authenticated, given valid data, should return 401')]
    public function testShouldNotAllowCreation(): void
    {
        $response = $this->postJson('api/profiles', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'image_url' => 'https://www.google.fr',
        ]);

        $response->assertUnauthorized();
    }

    #[TestDox('When user is authenticated, should list all profiles')]
    public function testShouldListAllProfiles(): void
    {
        $user = UserFactory::new()->createOne(['id' => 1]);

        ProfileFactory::new()->for($user, 'creator')->active()->createMany(3);
        ProfileFactory::new()->for($user, 'creator')->pending()->createOne();

        $response = $this->actingAs($user, 'sanctum')->getJson('api/profiles');

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data');
    }

    #[TestDox('When user is unauthenticated, should return only active profiles')]
    public function testShouldListActiveProfiles(): void
    {
        $user = UserFactory::new()->createOne(['id' => 1]);

        ProfileFactory::new()->for($user, 'creator')->pending()->createMany(3);
        ProfileFactory::new()->for($user, 'creator')->active()->createOne();

        $response = $this->getJson('api/profiles');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
