<?php

namespace App\Tests\Feature\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicTacToeApiControllerTest extends WebTestCase
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
    }

    /**
     * Simulate the following game:
     *  1 | 2 | 1
     *  --|---|---
     *  1 | 2 | 1
     *  --|---|---
     *  2 | 1 | 2
     */
    public function testADrawGame(): void
    {
        $client = static::createClient();
        $client->request('POST', '/new_game');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $sessionId = $data['session_id'];

        $data = $this->makeAMove($sessionId, 1, 0);
        $board = [
                [1, null, null],
                [null, null, null],
                [null, null, null],
            ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 2, 1);
        $board = [
                [1, 2, null],
                [null, null, null],
                [null, null, null],
            ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 1, 3);
        $board = [
                [1, 2, null],
                [1, null, null],
                [null, null, null],
            ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 2, 6);
        $board = [
                [1, 2, null],
                [1, null, null],
                [2, null, null],
            ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 1, 5);
        $board = [
            [1, 2, null],
            [1, null, 1],
            [2, null, null],
            ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 2, 4);
        $board = [
            [1, 2, null],
            [1, 2, 1],
            [2, null, null],
        ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 1, 7);
        $board = [
            [1, 2, null],
            [1, 2, 1],
            [2, 1, null],
        ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 2, 8);
        $board = [
            [1, 2, null],
            [1, 2, 1],
            [2, 1, 2],
            ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 1, 2);
        $board = [
                [1, 2, 1],
                [1, 2, 1],
                [2, 1, 2],
            ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);
    }

    public function testInvalidPlayer(): void
    {
        self::$client = static::createClient();
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

    private function makeAMove(int $sessionId, int $player, int $position): array
    {
        self::$client->request('POST', '/move', [
            'session_id' => $sessionId,
            'player' => $player,
            'position' => $position,
        ]);
        $response = self::$client->getResponse();

        return json_decode($response->getContent(), true);
    }
}
