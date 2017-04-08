<?php

/**
 * Created by: Jesse Griffin
 * Date: 4/5/2017
 */
class NaavCalculator
{
    //$interestRate = $currentApiRate + $adminRateAdditional
    private $interestRate;

    //monthly interest rate = $interestRate/12
    private $mInterestRate;

    //$nthPower = #years * #payments
    private $nthPower;

    //user inputted variable on homepage - $loanAmount
    private $loanAmount;

    /**
     * NaavCalculator constructor.
     * @param $currentApiRate
     * @param $adminRateAdditional
     * @param $years
     * @param $payments
     * @param $loanAmount
     */
    public function __construct($currentApiRate, $adminRateAdditional, $years, $payments, $loanAmount)
    {
        $this->interestRate = $currentApiRate + $adminRateAdditional;
        $this->nthPower = $years * $payments;
        $this->loanAmount = $loanAmount;
    }

    public function calc()
    {
        //convert yearly interest rate to monthly interest rate:
        $this->mInterestRate = $this->interestRate / 12;

        $eqTop = $this->mInterestRate * $this->loanAmount;
        //echo $eqTop . " -> eqTop <br>";
        $eqBottomPart1 = 1 + $this->mInterestRate;
        //echo $eqBottomPart1  . " -> eqBottomPart1 <br>";
        $eqBottomPart2 = pow((float)$eqBottomPart1, -($this->nthPower));
        //echo $eqBottomPart2 . " -> eqBottomPart2 <br>";
        $eqBottom = 1 - $eqBottomPart2;
        //echo $eqBottom . " -> eqBottom <br>";
        //echo $eqTop/$eqBottom;exit;
        $naav = $eqTop / $eqBottom;

        //round result to 0 decimals for whole dollar amount:
        return round($naav, 0);
    }
}
