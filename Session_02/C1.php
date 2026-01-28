<?php
$weight = 50;   // cân nặng (kg)
$height = 1.6;  // chiều cao (m)

$bmi = $weight / ($height * $height);

if ($bmi < 18.5) {
    $status = "Underweight";
} elseif ($bmi < 25) {
    $status = "Normal";
} elseif ($bmi < 30) {
    $status = "Overweight";
} else {
    $status = "Obese";
}
?>

<h3>BMI Calculator</h3>
<p>BMI: <?php echo round($bmi, 2); ?></p>
<p>Status: <?php echo $status; ?></p>
