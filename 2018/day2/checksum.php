<?php

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
}

$inputVal = file_get_contents('input.txt');
$dataRows = explode(PHP_EOL, $inputVal);

$calculator = new ChecksumCalculator($dataRows);

echo $calculator->calculate() . "\n";