<?php
function calculateBMI(float $kg, float $m): string {
    $bmi = $kg / ($m * $m);
    $bmiRounded = round($bmi, 1);

    if ($bmi < 18.5) {
        $category = "Under";
    } elseif ($bmi < 25) {
        $category = "Normal";
    } else {
        $category = "Over";
    }

    return "BMI: {$bmiRounded} ({$category})";
}

echo calculateBMI(65, 1.7);
?>
