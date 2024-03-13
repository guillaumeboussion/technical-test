<?php

namespace Tests\Feature;

use Database\Factories\ProfileFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[TestDox('When user is authenticated, given valid data, should create profile')]
    public function testShouldCreateComment(): void
    {
        $user = UserFactory::new()->createOne(['id' => 1]);
        $profile = ProfileFactory::new()
            ->for(UserFactory::new(), 'creator')
            ->createOne();

        $response = $this->actingAs($user, 'sanctum')->postJson('api/profiles/'. $profile->id . '/comments', [
            'content' => 'This is a comment',
        ]);

        $response->assertStatus(201);
    }

    #[TestDox('When user is authenticated, given valid data but multiple comment for same user, should not create profile')]
    public function testShouldNotCreateMultipleCommentsOnProfile(): void
    {
        $user = UserFactory::new()->createOne(['id' => 1]);
        $profile = ProfileFactory::new()
            ->for(UserFactory::new(), 'creator')
            ->createOne();

        $response = $this->actingAs($user, 'sanctum')->postJson('api/profiles/'. $profile->id . '/comments', [
            'content' => 'This is a comment',
        ]);

        $response->assertStatus(201);

        $response = $this->actingAs($user, 'sanctum')->postJson('api/profiles/'. $profile->id . '/comments', [
            'content' => 'This is another comment that should be rejected',
        ]);

        $response->assertStatus(400);
    }

    #[TestDox('When user is authenticated, given missing data, should return validation error')]
    public function testShouldNotCreateCommentInvalidData(): void
    {
        $user = UserFactory::new()->createOne(['id' => 1]);
        $profile = ProfileFactory::new()
            ->for(UserFactory::new(), 'creator')
            ->createOne();

        $response = $this->actingAs($user, 'sanctum')->postJson('api/profiles/'. $profile->id . '/comments', [
            'content' => 'This is a comment that is extremely long and should not be allowed to be created. This is another sentence that is added to make the content even longer. This is another sentence that is added to make the content even longer. This is another sentence that is added to make the content even longer.',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('content');
    }

    #[TestDox('When user is not authenticated, given valid data, should return 401')]
    public function testShouldNotAllowCreation(): void
    {
        $profile = ProfileFactory::new()
            ->for(UserFactory::new(), 'creator')
            ->createOne();

        $response = $this->postJson('api/profiles/'. $profile->id . '/comments', [
            'content' => 'This is a comment',
        ]);

        $response->assertUnauthorized();
    }
}
