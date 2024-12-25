<?php

namespace Tests\Feature\Api\V1;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DeleteNoteTest extends TestCase
{
    use RefreshDatabase;

    private const ENDPOINT = '/api/V1/notes/%d';

    public function testDeleteNote(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user->id,
        ]);

        $requestUrl = sprintf(self::ENDPOINT, $note->id);
        $response = $this->actingAs($user)->deleteJson($requestUrl);

        $response->assertNoContent();
    }

    public function testCanOnlyDeleteOwnNote(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create();

        $requestUrl = sprintf(self::ENDPOINT, $note->id);
        $response = $this->actingAs($user)->deleteJson($requestUrl);

        $response->assertForbidden();
    }

    public function testCanOnlyDeleteExistingNote(): void
    {
        $user = User::factory()->create();

        $requestUrl = sprintf(self::ENDPOINT, time());
        $response = $this->actingAs($user)->deleteJson($requestUrl);

        $response->assertNotFound();
    }
}