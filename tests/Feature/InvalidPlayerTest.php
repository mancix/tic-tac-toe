<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvalidPlayerTest extends WebTestCase
{
    private static KernelBrowser $client;

    public static function setUpBeforeClass(): void
    {
        self::$client = static::createClient();
    }

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testInvalidPlayer(): void
    {
        self::$client->request('POST', '/new_game');
        $response = self::$client->getResponse();
        $data = json_decode($response->getContent(), true);
        $sessionId = $data['session_id'];

        self::$client->request('POST', '/move', [
            'session_id' => $sessionId,
            'player' => 3,
            'position' => 0,
        ]);
        $this->assertResponseStatusCodeSame(422);
    }
}
