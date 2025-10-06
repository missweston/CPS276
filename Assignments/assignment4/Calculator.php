<?php
 
 class Calculator {
    public $num1;
    public $num2;
    public $operator;

    public function add() {
        return $this->num1 + $this->num2;
    }   
    public function subtract() {
        return $this->num1 - $this->num2;
    }   
    public function multiply() {
        return $this->num1 * $this->num2;
    }
    public function divide() {
        if ($this->num2 == 0) {
            return "cannot divide a number by zero";
        }
        return $this->num1 / $this->num2;
    }

    public function calc($operator = null, $num1 = null, $num2 = null) {
        if (!isset($operator) || !isset($num1) || !isset($num2) || !is_string($operator) || !is_numeric($num1) || !is_numeric($num2)) {
            return "<p> Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers. </p>";
        }
         $this->operator = $operator;
            $this->num1 = $num1;    
            $this->num2 = $num2;

        if ($this->operator == "+") {
            return "<p> The calculation is $num1 + $num2. The answer is " . $this->add() . "</p>";

        } 
        elseif ($this->operator == "-") {
            return "<p> The calculation is $num1 - $num2. The answer is " . $this->subtract() . "</p>"; 
        }
        elseif ($this->operator == "*") {
            return "<p> The calculation is $num1 * $num2. The answer is " . $this->multiply() . "</p>";
        }   
        elseif ($this->operator == "/") {
            return "<p> The calculation is $num1 / $num2. The answer is " . $this->divide() . "</p>";
        }   
        else {
            return "Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.";
        }
    }
 }


 