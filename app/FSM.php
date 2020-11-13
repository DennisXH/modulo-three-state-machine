<?php
namespace App;

class FSM {
    private $fsmName;
    public $stateMap;
    public $transitionMap;
    public $currentState;

    public function __construct($fsmName) {
        $this->fsmName = $fsmName;
        $this->stateMap = [];
        $this->transitionMap = [];
    }

    public function addState(Stateful $state) {
        $this->stateMap[$state->getName()] = $state;
    }

    public function addTransition($from, $input, $to) {
        if (!isset($this->transitionMap[$from])) {
            $this->transitionMap[$from] = [];
        }

        $this->transitionMap[$from][$input] = $to;
    }

    public function apply(string $input) {
        if (!$this->isValid($input)) {
            throw new \Exception('Invaild Input: ' . $input);
        }
        if (!$this->hasCurrentState()) {
            throw new \Exception('Invaild current state');
        }

        $this->currentState = $this->getStateObj(
            $this->transitionMap[$this->currentState->getName()][$input]
        );
    }

    public function isValid($input): bool {
        return $input == Input::ONE || $input == Input::ZERO;
    }

    public function init(Stateful $state = null) {
        if (null === $state && !empty($this->stateMap)) {
            $this->currentState = clone reset($this->stateMap);
            return;
        }

        if (empty($this->stateMap)) {
            $this->addState($state);
        }

        $this->currentState = $state;
    }

    public function hasCurrentState(): bool {
        return null !== $this->currentState;
    }

    public function getCurrentState(): State {
        return $this->currentState;
    }

    public function getStateObj(string $stateName): State {
        return $this->stateMap[$stateName];
    }

    public function output(): string {
        if (empty($this->stateMap) || !$this->hasCurrentState()) {
            throw new \Exception('Can not find output');
        }

        return $this->currentState->getValue();
    }
}