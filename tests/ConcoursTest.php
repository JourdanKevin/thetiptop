<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ConcoursTest extends AbstractTest
{
    public function testGetOne(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/admin/concours/1');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(array('@id' => '/api/admin/concours/1'));
    }

    public function testGetList(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/concours');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(array('@id' => '/api/concours'));
    }
}
