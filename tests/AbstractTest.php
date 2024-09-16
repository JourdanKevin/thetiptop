<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;

class AbstractTest extends ApiTestCase
{
    private ?string $token = null;

    public function setUp(): void
    {
        self::bootKernel();
    }

    protected function createClientWithCredentials($token = null): Client
    {
        $token = $token ?: $this->testGetToken();
        return static::createClient([], ['headers' => ['authorization' => 'Bearer '. $token]]);
    }

    /**
     * Use other credentials if needed.
     */
    public function testGetToken($body = []): string
    {
        if ($this->token) {
            return $this->token;
        }
        $response = static::createClient()->request('POST', '/api/token', ['json' => $body ?: [
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]]);
        $this->assertResponseIsSuccessful();

        $data = $response->toArray();
        $this->token = $data['token'];
        $this->assertnotNull($this->token);

        return $data['token'];
    }
}
