<?php
function isAdult(?int $age): bool {
    if ($age === null) {
        return false;
    }
    return $age >= 18;
}

var_export(isAdult(null));
?>
