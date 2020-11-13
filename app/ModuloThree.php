<?php
namespace App;

class ModuloThree
{
    /** @var FSM */
    private $fsm;
    private $input;

    public function __construct()
    {
        $this->initFsm();
    }

    public function setInput(string $input)
    {
        $this->input = $input;
    }

    public function result(): string
    {
        foreach (str_split($this->input) as $char) {
            $this->fsm->apply($char);
        }

        return $this->fsm->getCurrentState()->getValue();
    }

    public function initFsm(): void {
        $fsm = new FSM('ModuloThree');
        $fsm->addState(new State('s0', 0));
        $fsm->addState(new State('s1', 1));
        $fsm->addState(new State('s2', 2));
        $fsm->addTransition('s0', Input::ONE, 's1');
        $fsm->addTransition('s0', Input::ZERO, 's0');
        $fsm->addTransition('s1', Input::ONE, 's0');
        $fsm->addTransition('s1', Input::ZERO, 's2');
        $fsm->addTransition('s2', Input::ONE, 's2');
        $fsm->addTransition('s2', Input::ZERO, 's1');

        $fsm->init();

        $this->fsm = $fsm;
    }
}