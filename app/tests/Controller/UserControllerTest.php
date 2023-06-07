<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UserControllerTest extends WebTestCase
{
    private const LOCAL_URL = 'http://127.0.0.1:8080/api';

    private static array $data = [
        'testSuccessCreateUser' => [
            'name' => 'testtest',
            'email' => 'test2@test.com',
            'created' => '2023-06-07 22:22:22',
        ],
        'testCreateUserShortName' => [
            'name' => 'short',
            'email' => 'test2@test.com',
            'created' => '2023-06-07 22:22:22',
        ],
        'testCreateUserWithAlreadyNameExists' => [
            'name' => 'testUser1',
            'email' => 'test2@test.com',
            'created' => '2023-06-07 22:22:22',
        ],
        'testCreateUserWithInvalidSymbols' => [
            'name' => 'testUser1!@~',
            'email' => 'test2@test.com',
            'created' => '2023-06-07 22:22:22',
        ],
        'testCreateUserWithDirtyWords' => [
            'name' => 'pornohub',
            'email' => 'test2@test.com',
            'created' => '2023-06-07 22:22:22',
        ],
        'testCreateUserWithAlreadyEmailExists' => [
            'name' => 'testUser2',
            'email' => 'test@test.com',
            'created' => '2023-06-07 22:22:22',
        ],
        'testCreateUserWithInvalidEmailFormat' => [
            'name' => 'testUser2',
            'email' => 'test2@test',
            'created' => '2023-06-07 22:22:22',
        ],
        'testCreateUserWithForbiddenDomain' => [
            'name' => 'testUser2',
            'email' => 'test2@yahoo.com',
            'created' => '2023-06-07 22:22:22',
        ],
        'testSuccessUpdateUser' => [
            'name' => 'testUser2',
            'email' => 'test2@test.com',
            'created' => '2023-06-08 22:22:22',
        ],
        'testSoftDeleteUserWhenCreatedFieldLessThanDeletedField' => [
            'name' => 'testUser2',
            'email' => 'test2@test.com',
            'created' => '2023-06-08 22:22:22',
            'deleted' => '2023-06-08 22:22:20',
        ],
    ];

    public function testSuccessGetUser(): void
    {
        $client = static::createClient();

        $client->request('GET', self::LOCAL_URL . '/users/1');

        $this->assertResponseIsSuccessful();
    }

    public function testNotFoundUser(): void
    {
        $client = static::createClient();

        $client->request('GET', self::LOCAL_URL . '/users/2');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testSuccessCreateUser(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', self::LOCAL_URL . '/users', self::$data['testSuccessCreateUser']);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserShortName(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', self::LOCAL_URL . '/users', self::$data['testCreateUserShortName']);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreateUserWithAlreadyNameExists(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', self::LOCAL_URL . '/users', self::$data['testCreateUserWithAlreadyNameExists']);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreateUserWithInvalidSymbols(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', self::LOCAL_URL . '/users', self::$data['testCreateUserWithInvalidSymbols']);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreateUserWithDirtyWords(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', self::LOCAL_URL . '/users', self::$data['testCreateUserWithDirtyWords']);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreateUserWithAlreadyEmailExists(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', self::LOCAL_URL . '/users', self::$data['testCreateUserWithAlreadyEmailExists']);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreateUserWithInvalidEmailFormat(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', self::LOCAL_URL . '/users', self::$data['testCreateUserWithInvalidEmailFormat']);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreateUserWithForbiddenDomain(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', self::LOCAL_URL . '/users', self::$data['testCreateUserWithForbiddenDomain']);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testSuccessUpdateUser(): void
    {
        $client = static::createClient();

        $client->jsonRequest('PUT', self::LOCAL_URL . '/users/1', self::$data['testSuccessUpdateUser']);

        $this->assertResponseIsSuccessful();
    }

    public function testSoftDeleteUserWhenCreatedFieldLessThanDeletedField(): void
    {
        $client = static::createClient();

        $client->jsonRequest('PUT', self::LOCAL_URL . '/users/1', self::$data['testSoftDeleteUserWhenCreatedFieldLessThanDeletedField']);

        $this->assertResponseStatusCodeSame(400);
    }
}
