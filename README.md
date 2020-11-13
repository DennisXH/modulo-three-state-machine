# Modulo Three State Machine

### Introduction

Consider a string of ones and zeros representing an unsigned binary integer. Let us implement a modulo-three function that will compute the remainder when the represented value is divided by three.

One way to implement this would be to convert the input string to a number type and use the modulus operator (%). While that approach will produce the correct answer, for this exercise we wish you to use a more efficient and far more interesting method derived from the world of computer hardware.

### Finite State Machine (FSM)

Let us build an FSM that takes the input characters, one at a time, MOST significant bit first and transitions between a set of states as specified by the following state transition diagram:

The value that is returned from our function will depend on the state which is set after the character sequence has been exhausted. The final state will be converted to a remainder value as specified in the following table:

### Standard Exercise
With the help of the examples below, implement a state transition algorithm to implement the ‘mod-three’ procedure. Your solution should be well tested and demonstrate good programming practices.

**Example 1**

For input string ​”110”​ the machine will operate as follows:
1. Initial state = S0, Input = 1, result state = S1
2. Current state = S1, Input = 1, result state = S0
3. Current state = S0, Input = 0, result state = S0
4. No more input
5. Print output value (output for state S0 = 0) <---- This is the answer

**Example 2**

For input string ​”1010”​ the machine will operate as follows:
1. Initial state = S0, Input = 1, result state = S1
2. Current state = S1, Input = 0, result state = S2
3. Current state = S2, Input = 1, result state = S2
4. Current state = S2, Input = 0, result state = S1
5. No more input
6. Print output value (output for state S1 = 1) <---- This is the answer
