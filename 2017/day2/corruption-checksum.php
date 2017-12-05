<?php

class ChecksumCalculator
{
    private $dataRows;

    private $checksum;

    private $evenDistrobutionSum;

    public function getChecksum() : int
    {
        return $this->checksum;
    }

    public function getEvenDistrobutionSum(): int
    {
        return $evenDistrobutionSum;
    }

    public function setData(array $dataRows)
    {
        $this->dataRows = $dataRows;
    }

    public function calculateChecksum()
    {
        // always start from zero so that the same object can be used repeatedly without corrupting the data
        $this->checksum = 0;

        foreach ($this->dataRows as $dataRow)
        {
            $this->checksum += $this->calculateCheckumRow($dataRow);
        }

        return $this->checksum;
    }

    private function calculateCheckumRow(array $data)
    {
        $min = (int)min($data);
        $max = (int)max($data);
        $diff = $max - $min;

        return $diff;
    }

    public function calculateEvenlyDistributedSum()
    {
        // always start from zero so that the same object can be used repeatedly without corrupting the data
        $this->evenDistrobutionSum = 0;

        foreach ($this->dataRows as $dataRow) {
            $this->evenDistrobutionSum += $this->calculateEvenDistributionRow($dataRow);
        }

        return $this->evenDistrobutionSum;
    }

    private function calculateEvenDistributionRow(array $data)
    {
        $diff = 0;

        foreach ($data as $key => $number) {
            foreach ($data as $nestedKey => $nestedNumber) {
                if ($key === $nestedKey) {
                    continue;
                }
                if ((int)$number % (int)$nestedNumber === 0) {
                    $diff += (int)$number / (int)$nestedNumber;
                }
            }
        }

        return $diff;
    }
}

$handle = fopen("input.txt", "r");
$dataRows = [];

while (($data = fgetcsv($handle, 0, "\t")) !== false) {
    $dataRows[] = $data;
}
fclose($handle);

$checksumCalculator = new ChecksumCalculator();
$checksumCalculator->setData($dataRows);

echo $checksumCalculator->calculateChecksum() . "\n";

echo $checksumCalculator->calculateEvenlyDistributedSum() . "\n";

