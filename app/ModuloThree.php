<?php
namespace App;

class ModuloThree
{
    /** @var StateMachine */
    private $stateMachine;
    private $input;

    public function __construct(StateMachine $stateMachine)
    {
        $this->stateMachine = $stateMachine;
    }

    public function setInput(string $input)
    {
        $this->input = $input;
    }

    public function result(): string
    {
        foreach (str_split($this->input) as $char) {
            $this->stateMachine->apply($char);
        }

        return $this->stateMachine->getCurrentState()->getValue();
    }

    public function init(): void {
        $this->stateMachine->addState(new State('s0', 0));
        $this->stateMachine->addState(new State('s1', 1));
        $this->stateMachine->addState(new State('s2', 2));
        $this->stateMachine->addTransition('s0', Input::ONE, 's1');
        $this->stateMachine->addTransition('s0', Input::ZERO, 's0');
        $this->stateMachine->addTransition('s1', Input::ONE, 's0');
        $this->stateMachine->addTransition('s1', Input::ZERO, 's2');
        $this->stateMachine->addTransition('s2', Input::ONE, 's2');
        $this->stateMachine->addTransition('s2', Input::ZERO, 's1');

        $this->stateMachine->init();
    }
}