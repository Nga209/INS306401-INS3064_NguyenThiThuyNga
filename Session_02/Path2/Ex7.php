<?php
$numbers = [1, 2, 3];
$reversed = [];

for ($i = count($numbers) - 1; $i >= 0; $i--) {
    $reversed[] = $numbers[$i];
}

print_r($reversed);
?>
