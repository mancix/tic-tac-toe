<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MatchDraftTest extends WebTestCase
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
     *  1 | 2 | 1
     *  --|---|---
     *  1 | 2 | 1
     *  --|---|---
     *  2 | 1 | 2
     */
    public function testADrawGame(): void
    {
        self::$client->request('POST', '/new_game');
        $response = self::$client->getResponse();
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
