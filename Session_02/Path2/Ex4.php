<?php
$prices = [10, 20, 5];
$total = 0;

foreach ($prices as $price) {
    $total += $price;
}

echo "Total: " . $total;
?>
