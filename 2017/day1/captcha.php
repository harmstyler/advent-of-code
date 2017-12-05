<?php

class CaptchaChecker
{
    private $captcha;

    private $sum;

    public function setCaptcha(string $captcha)
    {
        $this->captcha = $captcha;
    }

    public function calculate(): string
    {
        $numbers = str_split($this->captcha);
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



