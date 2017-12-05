<?php

class ChecksumCalculator
{
    private $dataRows;

    private $checksum;

    public function getChecksum() : int
    {
        return $this->checksum;
    }

    public function setData(array $dataRows)
    {
        $this->dataRows = $dataRows;
    }

    public function calculate()
    {
        // always start from zero so that the same object can be used repeatedly without corrupting the data
        $this->checksum = 0;

        foreach ($this->dataRows as $dataRow)
        {
            $this->checksum += $this->calculateRow($dataRow);
        }

        return $this->checksum;
    }

    private function calculateRow(array $data)
    {
        $min = (int)min($data);
        $max = (int)max($data);
        $diff = $max - $min;

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

echo $checksumCalculator->calculate() . "\n";
