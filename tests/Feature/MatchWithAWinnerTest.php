<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MatchWithAWinnerTest extends WebTestCase
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

    /**
     * Simulate the following game:
     *    | 2 | 1
     *  --|---|---
     *  2 | 1 | 1
     *  --|---|---
     *  2 |   | 1
     *
     * the winner is player 1
     */
    public function testADrawGame(): void
    {
        self::$client->request('POST', '/new_game');
        $response = self::$client->getResponse();
        $data = json_decode($response->getContent(), true);
        $sessionId = $data['session_id'];

        $data = $this->makeAMove($sessionId, 1, 4);
        $board = [
            [null, null, null],
            [null, 1, null],
            [null, null, null],
        ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 2, 1);
        $board = [
            [null, 2, null],
            [null, 1, null],
            [null, null, null],
        ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 1, 2);
        $board = [
            [null, 2, 1],
            [null, 1, null],
            [null, null, null],
        ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 2, 6);
        $board = [
            [null, 2, 1],
            [null, 1, null],
            [2, null, null],
        ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 1, 5);
        $board = [
            [null, 2, 1],
            [null, 1, 1],
            [2, null, null],
        ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 2, 3);
        $board = [
            [null, 2, 1],
            [2, 1, 1],
            [2, null, null],
        ];
        $this->assertNull($data['winner']);
        $this->assertEquals($board, $data['board']);

        $data = $this->makeAMove($sessionId, 1, 8);
        $board = [
            [null, 2, 1],
            [2, 1, 1],
            [2, null, 1],
        ];
        $this->assertEquals(1, $data['winner']);
        $this->assertEquals($board, $data['board']);
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
