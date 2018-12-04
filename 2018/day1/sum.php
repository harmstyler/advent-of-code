<?php

$executionStartTime = microtime(true);

class SumGenerator
{
    private $input;
    private $total;
    private $firstRepeatedFrequency;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function setInput($input)
    {
        $this->input = $input;
    }

    public function getTotal(): int
    {
        if (null === $this->total) {
            $this->total = $this->calcTotal();
        }

        return $this->total;
    }

    public function getFirstRepeatedFrequency()
    {
        if (null === $this->firstRepeatedFrequency) {
            $this->firstRepeatedFrequency = $this->findFirstRepeatedFrequency();
        }

        return $this->firstRepeatedFrequency;
    }

    private function calcTotal(): int
    {
        $total = 0;
        $lines = explode(PHP_EOL, $this->input);
        foreach ($lines as $line) {
            $total += intval($line);
        }

        return $total;
    }

    private function findFirstRepeatedFrequency(): int
    {
        $frequencies = [0];
        while (true) {
            $repeated = $this->calcRepeatedFrequency($frequencies);
            if ($repeated) {
                return $repeated;
            }
        }
    }

    private function calcRepeatedFrequency(&$frequencies)
    {
        $currFrequency = end($frequencies);
        $lines = explode(PHP_EOL, $this->input);
        foreach ($lines as $line) {
            $currFrequency += intval($line);
            if (in_array($currFrequency, $frequencies)) {
                return $currFrequency;
            }
            $frequencies[] = $currFrequency;
        }

        return false;
    }
}


$inputVal = file_get_contents('input.txt');

$sumGenerator =  new SumGenerator(trim($inputVal));

echo "Getting Total \n";
echo $sumGenerator->getTotal() ."\n";

echo "Getting First Repeated Frequency \n";
echo $sumGenerator->getFirstRepeatedFrequency() ."\n";

$executionEndTime = microtime(true);

$seconds = $executionEndTime - $executionStartTime;

echo "This script took " . round($seconds, 2) . " seconds to execute.\n";
