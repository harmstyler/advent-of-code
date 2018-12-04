<?php

$executionStartTime = microtime(true);

class ChecksumCalculator
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function calculate(): int
    {
        $twoLetterCount = 0;
        $threeLetterCount = 0;

        foreach ($this->data as $datum) {
            list($hasTwoLettersRepeated, $hasThreeLettersRepeated) = $this->checkRepeatedLetters($datum);
            if ($hasTwoLettersRepeated) {
                $twoLetterCount++;
            }
            if ($hasThreeLettersRepeated) {
                $threeLetterCount++;
            }
        }

        return $twoLetterCount * $threeLetterCount;
    }

    private function checkRepeatedLetters(string $test): array
    {
        $countList = [];
        $testChars = str_split($test);
        foreach ($testChars as $testChar) {
            if (array_key_exists($testChar, $countList)) {
                $countList[$testChar] = ($countList[$testChar] === 3) ? 3 : $countList[$testChar] + 1;
            } else {
                $countList[$testChar] = 1;
            }
        }


        $hasTwoLettersRepeated = in_array(2, $countList);
        $hasThreeLettersRepeated = in_array(3, $countList);


        return array($hasTwoLettersRepeated, $hasThreeLettersRepeated);
    }

    public function findDiffByOne(): string
    {
        $offByOnes = [];
        for ($i = 0; $i < count($this->data); $i++) {
            $arr1 = str_split($this->data[$i]);
            foreach($this->data as $datum) {
                $arr2 = str_split($datum);
                $test = array_diff_assoc($arr1, $arr2);
                if (count($test) === 1) {
                    $offByOnes = array_diff_assoc($arr1, $test);
                    break 2;
                }
            }
        }

        return implode($offByOnes);
    }
}

$inputVal = file_get_contents('input.txt');
$dataRows = explode(PHP_EOL, $inputVal);

$calculator = new ChecksumCalculator($dataRows);

echo "checksum: ";

echo $calculator->calculate() . "\n";

echo "Searching for 'Off By One' chars...\n";

echo $calculator->findDiffByOne() . "\n";

$executionEndTime = microtime(true);

$seconds = $executionEndTime - $executionStartTime;

echo "This script took " . round($seconds, 2) . " seconds to execute.\n";
