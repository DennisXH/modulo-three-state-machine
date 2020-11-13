<?php

use App\State;
use PHPUnit\Framework\TestCase;

final class ModuloThreeTest extends TestCase
{
    public function testActualResult()
    {
        $input = '110';
        $modThree = $this->initModThree(new \App\StateMachine(), $input);

        $this->assertEquals(bindec($input) % 3, intval($modThree->result()));
    }

    public function testResult()
    {
        $input = '110';
        $result = strval(bindec($input) % 3);
        $mockStateMachine = Mockery::mock(\App\StateMachine::class)->makePartial();
        $mockStateMachine
            ->shouldReceive('apply')
            ->times(3);
        $mockStateMachine
            ->shouldReceive('getCurrentState->getValue')
            ->once()
            ->andReturn($result);

        $modThree = $this->initModThree($mockStateMachine, $input);

        $this->assertEquals($result, $modThree->result());
    }

    private function initModThree(\App\StateMachine $stateMachine, $input)
    {
        $modThree = new \App\ModuloThree($stateMachine);
        $modThree->setInput($input);
        $modThree->init();

        return $modThree;
    }
}