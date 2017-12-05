<?php

class Validator
{
    private $passPhraseList;

    private $validList;

    public function __construct(array $list)
    {
        $this->validList = [];
        $this->passPhraseList = $list;
    }

    public function validateAll(): array
    {
        foreach ($this->passPhraseList as $passPhrase) {
            if ($this->isValid($passPhrase)) {
                $this->validList[] = $passPhrase;
            }
        }

        return $this->validList;
    }

    private function isValid(string $passPhrase): bool
    {
        $words = explode(' ', $passPhrase);
        foreach ($words as $key1 => $word) {
            foreach ($words as $key2 => $testWord) {
                if ($key1 === $key2) {
                    continue;
                }
                if ($word === $testWord) {
//                    echo "\nbad  passphrase: ". $passPhrase;
                    return false;
                }
            }
            unset($words[$key1]);
        }

        return true;
    }
}

$wordList = file('sample.txt', FILE_IGNORE_NEW_LINES);


$validator = new Validator($wordList);
$validatedPassPhrases = $validator->validateAll();

echo count($validatedPassPhrases);
echo "\n";
