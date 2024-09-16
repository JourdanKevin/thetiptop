<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class TicketTest extends AbstractTest
{
    public function testGetOneById(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/admin/ticket/01HAVWV2M1JESYVV060N92X2AQ');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(array('@id' => '/api/admin/ticket/01HAVWV2M1JESYVV060N92X2AQ'));
    }

    public function testGetOneByNumero(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/ticket/01HAVWV2M1JESYVV060N92X2AQ/lot');
        $this->assertResponseIsSuccessful();
    }

    public function testGetList(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/admin/ticket');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(array('@id' => '/api/admin/ticket'));
    }
}
