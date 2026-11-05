<?php
class Addition {
    public function addition(mixed ...$numbers): int|float {
        if (count($numbers) < 2) throw new InvalidArgumentException("At least two values are required.");
        foreach ($numbers as $number) {
            if (!is_numeric($number)) throw new InvalidArgumentException("Only numeric values are allowed.");
        }
        return array_sum($numbers);
    }
}
$add = new Addition();
echo "Two values: " . $add->addition(10, 20) . "<br>";
echo "Three values: " . $add->addition(10, 20, 30) . "<br>";
echo "Decimal values: " . $add->addition(10.5, 20.5);
?>