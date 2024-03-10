<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateNewGameSessionTest extends WebTestCase
{
    private static KernelBrowser $client;

    public static function setUpBeforeClass(): void
    {
        self::$client = static::createClient();
        self::$client->catchExceptions(false);
    }

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateGameSession(): void
    {
        self::$client->request('POST', '/new_game');
        $this->assertResponseIsSuccessful();

        $response = self::$client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertIsNumeric($data['session_id']);
    }
}
