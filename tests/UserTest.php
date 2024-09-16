<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class UserTest extends AbstractTest
{
    public function testGetOneByEmail(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/user/admin2@thetiptop.fr');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(array('email' => 'admin2@thetiptop.fr'));
    }

    public function testGetOneById(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/admin/user/1');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(array('@id' => '/api/admin/user/1'));
    }

    public function testGetAccount(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/account');
        $this->assertResponseIsSuccessful();
    }

    public function testGetList(): void
    {
        $token = $this->testGetToken([
            'email' => 'admin2@thetiptop.fr',
            'password' => 'thetiptop1234',
        ]);
        
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/admin/user');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(array('@id' => '/api/admin/user'));
    }
}
