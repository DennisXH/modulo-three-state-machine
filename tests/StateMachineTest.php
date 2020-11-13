<?php


use App\Input;
use App\State;

class StateMachineTest extends \PHPUnit\Framework\TestCase
{
    public function testAddState()
    {
        $state = new \App\State('s0', 0);
        $stateMachine = new \App\StateMachine();
        $stateMachine->addState($state);
        $this->assertInstanceOf(\App\Stateful::class, $stateMachine->getStateObj('s0'));

        $stateName = 's0';
        $mockState = Mockery::mock(\App\Stateful::class);
        $mockState
            ->shouldReceive('getName')
            ->once()
            ->andReturn($stateName);
        $stateMachine->addState($mockState);
        $this->assertInstanceOf(\App\Stateful::class, $stateMachine->getStateObj('s0'));
    }

    public function testAddTransition()
    {
        $from = 's0';
        $input = '1';
        $to = 's1';
        $stateMachine = new \App\StateMachine();
        $stateMachine->addTransition($from, $input, $to);
        $this->assertEquals($to, $stateMachine->getTransition($from, $input));
    }

    public function testApply()
    {
        $s0 = new State('s0', 0);
        $s1 = new State('s1', 1);
        $stateMachine = new \App\StateMachine();
        $stateMachine->addState($s0);
        $stateMachine->addState($s1);
        $stateMachine->addTransition('s0', Input::ONE, 's1');
        $stateMachine->init();
        $stateMachine->apply('1');

        $this->assertInstanceOf(\App\Stateful::class, $stateMachine->getCurrentState());
        $this->assertEquals($s1, $stateMachine->getCurrentState());
    }

    public function testApplyInvalidInput()
    {
        $this->expectExceptionMessage('Invalid Input: 2');
        $stateMachine = new \App\StateMachine();
        $stateMachine->apply('2');
    }

    public function testApplyDoesntInitCurrentState()
    {
        $this->expectExceptionMessage('Invalid current state');
        $stateMachine = new \App\StateMachine();
        $stateMachine->apply('1');
    }

    public function testOutput()
    {
        $s0 = new State('s0', 0);
        $stateMachine = new \App\StateMachine();
        $stateMachine->addState($s0);
        $stateMachine->init();
        $this->assertEquals(0, $stateMachine->output());

        $mockState = Mockery::mock(\App\Stateful::class);
        $mockState
            ->shouldReceive('getName')
            ->once()
            ->andReturn('s0');
        $mockState
            ->shouldReceive('getValue')
            ->once()
            ->andReturn(0);
        $stateMachine2 = new \App\StateMachine();
        $stateMachine2->addState($mockState);
        $stateMachine2->init();
        $this->assertEquals(0, $stateMachine2->output());
    }
}