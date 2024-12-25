<?php

namespace Tests\Feature\Api\V1\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    private const ENDPOINT = '/api/V1/users/login';

    private const VALID_USERNAME = 'blackWolf';

    private const VALID_EMAIL = 'test@gmail.com';

    private const VALID_PASSWORD = 'A$trongPassword123';

    public function testLoginUser(): void
    {
        $user = User::factory()->create([
            'password' => self::VALID_PASSWORD,
        ]);

        $response = $this->postJson(self::ENDPOINT, [
            'username' => $user->username,
            'password' => self::VALID_PASSWORD,
        ]);

        $response->assertOk();
    }

    #[DataProvider('validateDataProvider')]
    public function testLoginUserValidation(array $data, string $validationField): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(self::ENDPOINT, $data);

        $response->assertUnauthorized();
    }

    public static function validateDataProvider(): array
    {
        return [
            'missing: username' => [
                'data' => [
                    'email' => self::VALID_EMAIL,
                    'password' => self::VALID_PASSWORD,
                ],
                'validationField' => 'username',
            ],
            'missing: password' => [
                'data' => [
                    'username' => self::VALID_USERNAME,
                    'email' => self::VALID_EMAIL,
                ],
                'validationField' => 'password',
            ],
        ];
    }
}