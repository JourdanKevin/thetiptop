<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class PrizeTest extends AbstractTest
{
    public function testGetOne(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/prize/1');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(array('@id' => '/api/prize/1'));
    }

    public function testGetOneRandom(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/random/prize');
        $this->assertResponseIsSuccessful();
    }

    public function testGetList(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/prize');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(array('@id' => '/api/prize'));
    }
}
