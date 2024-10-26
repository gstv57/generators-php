<?php

function getProductsGenerator(): Generator
{
    foreach (range(1, 1000000) as $i) {
        yield [
            'id' => $i,
            'name' => "Product #{$i}",
            'price' => rand(9, 99),
        ];
    }
}

function getProductsArray(): array
{
    $array = [];
    for($i = 1; $i <= 1000000; $i++) {
        $array[] = [
            'id' => $i,
            'name' => "Product #{$i}",
            'price' => rand(9, 99),
        ];
    }
    return $array;
}

function testWithGenerator(): float
{
    $inicio = hrtime(true);
    
    // consuming
    foreach(getProductsGenerator() as $product) {
        // simule some process
        $dummy = print_r($product, true);
    }
    
    $fim = hrtime(true);
    return ($fim - $inicio) / 1e9;
}

function testWithArray(): float
{
    $inicio = hrtime(true);
    
   // consuming
    $produtos = getProductsArray();
    foreach($produtos as $product) {
        // simule some process
        $dummy = print_r($product, true);
    }
    
    $fim = hrtime(true);
    return ($fim - $inicio) / 1e9;
}

$iterations = 1;
$generatorTimes = [];
$arrayTimes = [];

for($i = 0; $i < $iterations; $i++) {
    $generatorTimes[] = testWithGenerator();
    $arrayTimes[] = testWithArray();
}

$avgGenerator = array_sum($generatorTimes) / count($generatorTimes);
$avgArray = array_sum($arrayTimes) / count($arrayTimes);

echo "Average with Generator: " . number_format($avgGenerator, 6) . " segundos\n";
echo "Average with Array: " . number_format($avgArray, 6) . " segundos\n";
echo "Approximate memory difference: " . (memory_get_peak_usage(true) / 1024 / 1024) . "MB\n";