<?php
function safeDiv(float $a, float $b): ?float {
    if ($b == 0) {
        return null;
    }
    return $a / $b;
}

var_dump(safeDiv(10, 0));
?>
