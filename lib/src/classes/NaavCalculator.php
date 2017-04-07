<?php

/**
 * Created by: Jesse Griffin
 * Date: 4/5/2017
 */
class NaavCalculator
{
    //$interestRate = $currentApiRate + $adminRateAdditional
    private $interestRate;

    //$nthPower = #years * #payments
    private $nthPower;

    //user inputted variable on homepage - $loanAmount
    private $loanAmount;

    public function __construct($currentApiRate, $adminRateAdditional, $years, $payments, $loanAmount)
    {
        $this->interestRate = $currentApiRate + $adminRateAdditional;
        $this->nthPower = $years * $payments;
        $this->loanAmount = $loanAmount;
    }

    public function calc()
    {
        $naav = ((($this->interestRate)*($this->loanAmount)) / (1 - (1 + $this->interestRate)^-$this->nthPower));
        return $naav;
    }
}