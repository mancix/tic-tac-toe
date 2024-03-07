<?php

namespace App\Tests\Unit\Service;

use App\Exception\AlreadyTakenPositionException;
use App\Exception\InvalidPlayerException;
use App\Exception\InvalidPositionException;
use App\Service\TicTacToeService;
use PHPUnit\Framework\TestCase;

class TicTacToeServiceTest extends TestCase
{
    private TicTacToeService $ticTacToeService;

    protected function setUp(): void
    {
        $this->initializeBoard();
        parent::setUp();
    }

    public function testSuccessfullyMakeAMove(): void
    {
        $this->initializeBoard();

        $this->ticTacToeService->makeAMove(1, 0);

        $expected = [
            [1, null, null],
            [null, null, null],
            [null, null, null],
        ];

        $this->assertEquals($expected, $this->ticTacToeService->getBoard());

        $this->initializeBoard();

        $expected = [
            [null, 1, null],
            [null, null, null],
            [null, null, null],
        ];

        $this->ticTacToeService->makeAMove(1, 1);
        $this->assertEquals($expected, $this->ticTacToeService->getBoard());

        $this->initializeBoard();

        $expected = [
            [null, null, 1],
            [null, null, null],
            [null, null, null],
        ];
        $this->ticTacToeService->makeAMove(1, 2);

        $this->assertEquals($expected, $this->ticTacToeService->getBoard());

        $this->initializeBoard();

        $expected = [
            [null, null, null],
            [2, null, null],
            [null, null, null],
        ];

        $this->ticTacToeService->makeAMove(2, 3);

        $this->assertEquals($expected, $this->ticTacToeService->getBoard());

        $this->initializeBoard();

        $expected = [
            [null, null, null],
            [null, 2, null],
            [null, null, null],
        ];

        $this->ticTacToeService->makeAMove(2, 4);

        $this->assertEquals($expected, $this->ticTacToeService->getBoard());

        $this->initializeBoard();

        $expected = [
            [null, null, null],
            [null, null, 2],
            [null, null, null],
        ];

        $this->ticTacToeService->makeAMove(2, 5);

        $this->assertEquals($expected, $this->ticTacToeService->getBoard());
        $this->initializeBoard();

        $expected = [
            [null, null, null],
            [null, null, null],
            [1, null, null],
        ];

        $this->ticTacToeService->makeAMove(1, 6);

        $this->assertEquals($expected, $this->ticTacToeService->getBoard());

        $this->initializeBoard();

        $expected = [
            [null, null, null],
            [null, null, null],
            [null, 1, null],
        ];

        $this->ticTacToeService->makeAMove(1, 7);

        $this->assertEquals($expected, $this->ticTacToeService->getBoard());

        $this->initializeBoard();

        $expected = [
            [null, null, null],
            [null, null, null],
            [null, null, 1],
        ];

        $this->ticTacToeService->makeAMove(1, 8);

        $this->assertEquals($expected, $this->ticTacToeService->getBoard());
    }

    public function testDiagonalWinner(): void
    {
        $this->ticTacToeService->makeAMove(1, 0);
        $this->ticTacToeService->makeAMove(2, 2);
        $this->ticTacToeService->makeAMove(1, 4);
        $this->ticTacToeService->makeAMove(2, 5);
        $this->ticTacToeService->makeAMove(1, 8);
        $this->assertEquals('1', $this->ticTacToeService->getWinner());
    }

    public function testRowWinner(): void
    {
        $this->ticTacToeService->makeAMove(1, 0);
        $this->ticTacToeService->makeAMove(2, 6);
        $this->ticTacToeService->makeAMove(1, 1);
        $this->ticTacToeService->makeAMove(2, 7);
        $this->ticTacToeService->makeAMove(1, 2);
        $this->assertEquals('1', $this->ticTacToeService->getWinner());
    }

    public function testColumnWinner(): void
    {
        $this->ticTacToeService->makeAMove(1, 0);
        $this->ticTacToeService->makeAMove(2, 2);
        $this->ticTacToeService->makeAMove(1, 3);
        $this->ticTacToeService->makeAMove(2, 4);
        $this->ticTacToeService->makeAMove(1, 6);
        $this->assertEquals('1', $this->ticTacToeService->getWinner());
    }

    public function testInvalidPosition(): void
    {
        $this->expectException(InvalidPositionException::class);
        $this->expectExceptionMessage('Invalid position');
        $this->ticTacToeService->makeAMove(1, 9);
    }

    public function testNumberOfRemainingMoves(): void
    {
        $this->assertEquals(9, $this->ticTacToeService->getNumberOfRemainingMoves());
        $this->ticTacToeService->makeAMove(1, 0);
        $this->assertEquals(8, $this->ticTacToeService->getNumberOfRemainingMoves());
        $this->ticTacToeService->makeAMove(2, 1);
        $this->assertEquals(7, $this->ticTacToeService->getNumberOfRemainingMoves());
        $this->ticTacToeService->makeAMove(1, 2);
        $this->assertEquals(6, $this->ticTacToeService->getNumberOfRemainingMoves());
        $this->ticTacToeService->makeAMove(2, 3);
        $this->assertEquals(5, $this->ticTacToeService->getNumberOfRemainingMoves());
        $this->ticTacToeService->makeAMove(1, 4);
        $this->assertEquals(4, $this->ticTacToeService->getNumberOfRemainingMoves());
        $this->ticTacToeService->makeAMove(2, 5);
        $this->assertEquals(3, $this->ticTacToeService->getNumberOfRemainingMoves());
        $this->ticTacToeService->makeAMove(1, 6);
        $this->assertEquals(2, $this->ticTacToeService->getNumberOfRemainingMoves());
        $this->ticTacToeService->makeAMove(2, 7);
        $this->assertEquals(1, $this->ticTacToeService->getNumberOfRemainingMoves());
        $this->ticTacToeService->makeAMove(1, 8);
        $this->assertEquals(0, $this->ticTacToeService->getNumberOfRemainingMoves());
    }

    private function initializeBoard(): void
    {
        $this->ticTacToeService = new TicTacToeService();
    }

    public function testInvalidPlayer(): void
    {
        $this->expectException(InvalidPlayerException::class);
        $this->expectExceptionMessage('Invalid player');
        $this->ticTacToeService->makeAMove(3, 0);
    }

    public function testAlreadyTakenPosition(): void
    {
        $this->expectException(AlreadyTakenPositionException::class);
        $this->expectExceptionMessage('Position already taken');
        $this->ticTacToeService->makeAMove(1, 0);
        $this->ticTacToeService->makeAMove(2, 0);
    }
}
