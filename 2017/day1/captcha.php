<?php

class CaptchaChecker
{
    const NEXT_DIGIT_CHECK = 1;
    const HALFWAY_AROUND_CHECK = 2;
    private $algorithm;

    private $captcha;

    private $sum;

    public function setAlorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    }

    public function setCaptcha(string $captcha)
    {
        $this->captcha = $captcha;
    }

    public function calculate(): string
    {
        $numbers = str_split($this->captcha);

        switch ($this->algorithm) {
            case self::HALFWAY_AROUND_CHECK:
                return $this->halfwayAroundCheck($numbers);
            default:
                return $this->nextDigitCheck($numbers);
        }
    }

    private function nextDigitCheck(array $numbers): string
    {
        $oldNumber = array_shift($numbers);
        $numbers[] = $oldNumber;
        $sum = 0;
        foreach ($numbers as $number) {
            if ($oldNumber === $number) {
                $sum += $number;
            }
            $oldNumber = $number;
        }

        return $sum;
    }

    private function halfwayAroundCheck(array $numbers): string
    {
        $sum = 0;
        $halfMark = count($numbers) / 2;
        $numberCount = count($numbers);
        $testNumber =array_merge(array_values($numbers), array_values($numbers));

        for ($i=0; $i < $numberCount; $i++) {
            if ($testNumber[$i] === $testNumber[$i+$halfMark]) {
                $sum += $testNumber[$i];
            }
        }

        return $sum;
    }
}


$captchaChecker = new CaptchaChecker();

// tests
// $captchaChecker->setCaptcha(1122);

// echo $captchaChecker->calculate() . "\n";

// $captchaChecker->setCaptcha(1111);

// echo $captchaChecker->calculate() . "\n";

// $captchaChecker->setCaptcha(1234);

// echo $captchaChecker->calculate() . "\n";

// $captchaChecker->setCaptcha(91212129);

// echo $captchaChecker->calculate() . "\n";

$inputVal = file_get_contents('input.txt');
$captchaChecker->setCaptcha(trim($inputVal));
echo $captchaChecker->calculate() . "\n";


$captchaChecker->setAlorithm($captchaChecker::HALFWAY_AROUND_CHECK);
echo $captchaChecker->calculate() . "\n";
